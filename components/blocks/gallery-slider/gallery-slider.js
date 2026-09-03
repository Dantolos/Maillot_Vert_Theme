/**
 * Gallery slider.
 *
 * Mounts every .js-mv-gallery on the page. The previous version hard-coded
 * #photo-slide, so a second gallery on the same page stayed dead – and it threw
 * when the pagination element was missing.
 */
(function () {
	"use strict";

	function mountGalleries() {
		if (typeof window.Splide === "undefined") {
			return;
		}

		var galleries = document.querySelectorAll(".js-mv-gallery");

		Array.prototype.forEach.call(galleries, function (element) {
			if (element.dataset.mvMounted === "true") {
				return;
			}

			element.dataset.mvMounted = "true";

			var slider = new window.Splide(element, {
				arrows: false,
				rewind: true,
				pauseOnHover: true,
				i18n: {
					prev: element.getAttribute("data-label-prev") || "Previous slide",
					next: element.getAttribute("data-label-next") || "Next slide",
				},
			});

			slider.on("mounted", function () {
				var pagination = element.querySelector(".splide__pagination");

				if (pagination) {
					pagination.classList.add("photo_splide__pagination");
				}
			});

			slider.mount();
		});
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", mountGalleries);
	} else {
		mountGalleries();
	}
})();
