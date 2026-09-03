/**
 * Manifest teaser slider.
 *
 * One card at a time, paginated with dots. No arrows: a single looping card
 * does not need four controls. Splide is declared as a dependency in
 * block.json, so it is only on the page when this block is.
 */
(function () {
	"use strict";

	function mount() {
		if (typeof window.Splide === "undefined") {
			return;
		}

		var sliders = document.querySelectorAll(".js-mv-manifest-slider");

		Array.prototype.forEach.call(sliders, function (element) {
			if (element.dataset.mvMounted === "true") {
				return;
			}

			element.dataset.mvMounted = "true";

			new window.Splide(element, {
				type: "loop",
				perPage: 1,
				arrows: false,
				pagination: true,
				autoHeight: true,
				speed: 500,
				easing: "cubic-bezier(.22,.61,.36,1)",
				reducedMotion: {
					speed: 0,
					autoplay: "pause"
				}
			}).mount();
		});
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", mount);
	} else {
		mount();
	}
})();
