// var myCarousel = document.querySelector('#myCarousel')
// var carousel = new bootstrap.Carousel(myCarousel, {
//   interval: 100000
// })

$('.carousel .carousel-item').each(function(){
  let minPerSlide = 4;
  let next = $(this).next();
  if (!next.length) {
  next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  for (let i=0;i<minPerSlide;i++) {
      console.log (i);
      next=next.next();
      if (!next.length) {
        next = $(this).siblings(':first');
      }
      
      next.children(':first-child').clone().appendTo($(this));
    }
});



// let carouselWidth = $(".carousel-inner")[0].scrollWidth;
// let cardWidth = $(".carousel-item").width();
// let scrollPosition = 0;

// $(".carousel-control-next").on("click", function () {
//     if (scrollPosition < (carouselWidth - cardWidth * 4)) {
//       scrollPosition += cardWidth;
//       $(".carousel-inner").animate({ scrollLeft: scrollPosition },600);
//     }
//   });

// $(".carousel-control-prev").on("click", function () {
// if (scrollPosition > 0) {
//     scrollPosition -= cardWidth;
//     $(".carousel-inner").animate(
//     { scrollLeft: scrollPosition },
//     600
//     );
// }
// });

// let multipleCardCarousel = document.querySelector(
//     "#carouselExampleControls"
//   );
//   if (window.matchMedia("(min-width: 768px)").matches) {
//     let carousel = new bootstrap.Carousel(multipleCardCarousel, {
//       interval: false
//     });
//   } else {
//     $(multipleCardCarousel).addClass("slide");
//   }

//   let carousel = new bootstrap.Carousel(multipleCardCarousel, {
//     interval: false,
//     wrap: false,
//   });