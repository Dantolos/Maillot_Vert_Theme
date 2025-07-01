document.addEventListener("DOMContentLoaded", function () {
  var splide = new Splide("#photo-slide", { arrows: false });
  splide.mount();
  const PhotoSlider = document.getElementById("photo-slide");
  PhotoSlider.querySelector(".splide__pagination").classList.add(
    "photo_splide__pagination",
  );
});

if (false) {
  document.addEventListener("DOMContentLoaded", function () {
    var splide = new Splide("#photo-slide", {
      padding: { left: "30%", right: "20%" },
      easing: "ease",
      perPage: 1,
      width: "60%",
      fixedWidth: "35vw",
      fixedHeight: "25vw",
      gap: "20px",
      focus: "center",
      arrows: false,
      autoplay: false,
      rewind: true,
      pauseOnHover: true,
      breakpoints: {
        960: {
          padding: { left: "50%", right: "50%" },
          width: "100%",
          fixedWidth: "70vw",
          fixedHeight: "40vw",
        },
        680: {
          padding: { left: "2%", right: "2%" },
          fixedWidth: "90vw",
          fixedHeight: "60vw",
        },
      },
    });
    splide.mount();
    const PhotoSlider = document.getElementById("photo-slide");
    PhotoSlider.querySelector(".splide__pagination").classList.add(
      "photo_splide__pagination",
    );
  });
}
