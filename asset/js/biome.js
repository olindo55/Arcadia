// Cards click
//--------------------

const biomeCards = document.querySelectorAll('.accordion-biome-card');

biomeCards.forEach(myBiomeCard => {
    myBiomeCard.addEventListener("click", function() {
      biomeCards.forEach(card => {
        card.parentElement.classList.remove('clicked');
      });
      myBiomeCard.parentElement.classList.toggle('clicked');
    });
});


// Swiper for carousel
//--------------------
const swiperAnimal = new Swiper('.swiperAnimal', {
    loop: true,
    slidesPerView: 3,
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

