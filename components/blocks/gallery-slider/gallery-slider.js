document.addEventListener( 'DOMContentLoaded', function() {
     var splide = new Splide( '#photo-slide', {
          padding: { left: '20%', right: '20%' },
          easing: 'ease',
          perPage: 1,
          width: '80%',
          fixedWidth : '35vw',
          fixedHeight: '25vw',
          gap        : '20px',
          focus: 'center',
          arrows: false,
          autoplay: false,
          rewind: true,
          pauseOnHover: true,
          breakpoints: { 
               600: {
                    padding: { left: '2%', right: '2%' },
               }
          }
     });
     splide.mount();
     const PhotoSlider = document.getElementById('photo-slide');
     PhotoSlider.querySelector('.splide__pagination').classList.add('photo_splide__pagination');
} );

