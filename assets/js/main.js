/**
 * Theme-wide front-end behaviour.
 *
 * Kept intentionally small - block specific JavaScript lives next to its block.
 */
(function () {
	"use strict";

	var root = document.documentElement;

	/* ---------------------------------------------------------------------- *
	 * Skip link
	 *
	 * Move focus to the main region so keyboard users continue from the
	 * content instead of the top of the document.
	 * ---------------------------------------------------------------------- */

	var skipLink = document.querySelector(".skip-link");
	var main = document.getElementById("main-container");

	if (skipLink && main) {
		skipLink.addEventListener("click", function () {
			main.setAttribute("tabindex", "-1");
			main.focus();
		});
	}

	/* ---------------------------------------------------------------------- *
	 * Scroll reveal
	 *
	 * One gesture for the whole site: a block fades up 14px as it enters the
	 * viewport, its grid children follow with a 45ms stagger. The CSS only
	 * hides anything once .js-anim is on <html>, which happens here - so with
	 * JavaScript off, an old browser, or reduced motion, every block is simply
	 * visible from the start.
	 * ---------------------------------------------------------------------- */

	var STAGGER_MS = 45;
	var STAGGER_MAX = 8; // Do not delay the tail of a long list into next week.

	var childSelector = [
		".fact-item",
		".program-row",
		".team-grid-member-item",
		".ticket-cta-box",
		".supporter-list-item",
		".supporter-link"
	].join(",");

	function prefersReducedMotion() {
		return (
			window.matchMedia &&
			window.matchMedia("(prefers-reduced-motion: reduce)").matches
		);
	}

	function setStagger(block) {
		var children = block.querySelectorAll(childSelector);
		var index = 0;

		Array.prototype.forEach.call(children, function (child) {
			child.style.setProperty(
				"--d",
				Math.min(index, STAGGER_MAX) * STAGGER_MS + "ms"
			);
			index++;
		});
	}

	function revealAll(blocks) {
		Array.prototype.forEach.call(blocks, function (block) {
			block.classList.add("is-in");
		});
	}

	function initReveal() {
		var blocks = document.querySelectorAll(".mv-block");

		if (!blocks.length) {
			return;
		}

		if (prefersReducedMotion() || !("IntersectionObserver" in window)) {
			revealAll(blocks);
			return;
		}

		root.classList.add("js-anim");

		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}

					entry.target.classList.add("is-in");
					observer.unobserve(entry.target);
				});
			},
			{ threshold: 0.12, rootMargin: "0px 0px -8% 0px" }
		);

		Array.prototype.forEach.call(blocks, function (block) {
			setStagger(block);
			observer.observe(block);
		});

		/*
		 * Safety net: if something goes wrong (a block that never intersects
		 * because it sits in a hidden container, for instance) show everything
		 * rather than leaving the page blank.
		 */
		window.setTimeout(function () {
			revealAll(document.querySelectorAll(".mv-block:not(.is-in)"));
		}, 3000);
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", initReveal);
	} else {
		initReveal();
	}
})();
