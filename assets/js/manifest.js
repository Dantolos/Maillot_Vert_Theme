/**
 * Shared manifest behaviour: the read-on overlay and the year filter.
 *
 * Loaded by both manifest blocks via block.json, so it is only on pages that
 * actually contain one of them. Translated strings come from PHP via
 * wp_localize_script, so nothing here has to guess the site language.
 */
(function () {
	"use strict";

	var i18n = window.mvManifest || {};
	var dialog = null;

	function each(list, fn) {
		Array.prototype.forEach.call(list, fn);
	}

	/* ---------------------------------------------------------------------- *
	 * Overlay
	 *
	 * Uses the native <dialog> element, which brings the focus trap, the
	 * backdrop and Escape-to-close with it. Cards whose statement fits are
	 * rendered without a trigger, so nothing here runs for them.
	 * ---------------------------------------------------------------------- */

	function buildDialog() {
		if (dialog) {
			return dialog;
		}

		dialog = document.createElement("dialog");
		dialog.className = "mv-manifest-dialog";

		var close = document.createElement("button");
		close.type = "button";
		close.className = "mv-manifest-dialog__close";
		close.setAttribute("data-close", "");
		close.setAttribute("aria-label", i18n.close || "Close");
		close.innerHTML = '<span aria-hidden="true">&times;</span>';

		var mark = document.createElement("span");
		mark.className = "mv-manifest-dialog__mark";
		mark.setAttribute("aria-hidden", "true");
		mark.innerHTML = "&bdquo;";

		var text = document.createElement("div");
		text.className = "mv-manifest-dialog__text";

		var foot = document.createElement("footer");
		foot.className = "mv-manifest-dialog__foot";

		dialog.appendChild(close);
		dialog.appendChild(mark);
		dialog.appendChild(text);
		dialog.appendChild(foot);
		document.body.appendChild(dialog);

		dialog.addEventListener("click", function (event) {
			// Clicking the backdrop closes; clicking the panel does not.
			if (event.target === dialog || event.target.closest("[data-close]")) {
				dialog.close();
			}
		});

		return dialog;
	}

	function openStatement(trigger) {
		var template = document.getElementById(
			trigger.getAttribute("data-mv-manifest-open")
		);

		if (!template || !template.content) {
			return;
		}

		var card = trigger.closest(".mv-manifest-card");
		var box = buildDialog();
		var text = box.querySelector(".mv-manifest-dialog__text");
		var foot = box.querySelector(".mv-manifest-dialog__foot");

		text.innerHTML = "";
		text.appendChild(template.content.cloneNode(true));

		foot.innerHTML = "";

		if (card) {
			each(
				card.querySelectorAll(
					".mv-manifest-card__year, .mv-manifest-card__author"
				),
				function (node) {
					foot.appendChild(node.cloneNode(true));
				}
			);
		}

		if (typeof box.showModal === "function") {
			box.showModal();
		} else {
			box.setAttribute("open", "");
		}
	}

	/* ---------------------------------------------------------------------- *
	 * Year filter
	 *
	 * Everything is already in the DOM, so filtering is a visibility switch -
	 * no reload, no request.
	 * ---------------------------------------------------------------------- */

	function applyFilter(group, year) {
		var wrapper = group.closest(".block-manifest-wall-wrapper");

		if (!wrapper) {
			return;
		}

		var empty = wrapper.querySelector("[data-mv-manifest-empty]");
		var visible = 0;

		each(wrapper.querySelectorAll(".manifest-wall-item"), function (item) {
			var match = year === "all" || item.getAttribute("data-year") === year;
			item.hidden = !match;

			if (match) {
				visible++;
			}
		});

		each(group.querySelectorAll("[data-year]"), function (chip) {
			chip.setAttribute(
				"aria-pressed",
				String(chip.getAttribute("data-year") === year)
			);
		});

		if (empty) {
			empty.hidden = visible !== 0;
		}
	}

	/* ---------------------------------------------------------------------- *
	 * Wiring
	 * ---------------------------------------------------------------------- */

	document.addEventListener("click", function (event) {
		var trigger = event.target.closest("[data-mv-manifest-open]");

		if (trigger) {
			openStatement(trigger);
			return;
		}

		var chip = event.target.closest("[data-mv-manifest-filter] [data-year]");

		if (chip) {
			applyFilter(
				chip.closest("[data-mv-manifest-filter]"),
				chip.getAttribute("data-year")
			);
		}
	});
})();
