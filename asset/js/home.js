const swiperService = new Swiper('.swiperService', {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 20,
    breakpoints: {
        640: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        1200: {
            slidesPerView: 3,
            spaceBetween: 40,
        },
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

const swiperComment = new Swiper('.swiperComment', {
    effect: "cards",
    slideShadows: false,
    grabCursor: true,
    autoplay: {
        delay: 5000,
        pauseOnMouseEnter: true,
      },
  });
  


// alert("test ok");

// Randomize card-service

const cardData = [ // à recuperer sur la BDD
  {
      src: "../../asset/images/services/visites_guidees.png",
      alt: "Un guide explique le zoo aux visiteurs",
      title: "Visites guidées"
  },
  {
      src: "../../asset/images/services/kristof-korody-udN5SKlmtqg-unsplash.jpg",
      alt: "Une assiette d'un plat servis dans notre restaurant",
      title: "Restauration"
  },
  {
      src: "../../asset/images/services/casey-horner-p69o_a7XqDM-unsplash.jpg",
      alt: "Le petit train sort du biome Jungle",
      title: "Petit train"
  },
  {
      src: "../../asset/images/services/daiga-ellaby-p-vf1RhLzsc-unsplash.jpg",
      alt: "Un soigneur nourrissant les animaux",
      title: "Nourrissage"
  },
  {
      src: "../../asset/images/services/ankush-minda-Bsxv_Nbs-VY-unsplash.jpg",
      alt: "Un spectacle de perroquet",
      title: "Spectacles"
  },
  {
      src: "../../asset/images/services/atelier-enfants.png",
      alt: "Atelier éducatif pour les enfants",
      title: "Ateliers éducatifs"
  },
  {
      src: "../../asset/images/services/butterfly-biodiversity-two-column.jpg.thumb.768.768.jpg",
      alt: "Différent papillonsDifférent papillons",
      title: "Expositions"
  }
]; 
const cards = document.querySelectorAll('.card-service');
let currentCardIndex = 0;
let cardUsed = [1, 2, 3];

function replaceSingleCard(card) {
  let randomIndex;  
  do {
      randomIndex = Math.floor(Math.random() * cardData.length);
    } while (cardUsed.includes(randomIndex));

    card.style.opacity = 0;
    setTimeout(() => {
      const newCardData = cardData[randomIndex];
      card.querySelector('img').src = newCardData.src;
      card.querySelector('img').alt = newCardData.alt;
      card.querySelector('h4').textContent = newCardData.title;
      card.style.opacity = 1;
    }, 1000);
    cardUsed[currentCardIndex] = randomIndex;
}

function replaceCardSequentially() {
    replaceSingleCard(cards[currentCardIndex]);
    currentCardIndex = (currentCardIndex + 1) % cards.length;
}

// setInterval(replaceCardSequentially, 7000);









// $('.carousel .carousel-item').each(function(){
//   let minPerSlide = 4;
//   let next = $(this).next();
//   if (!next.length) {
//   next = $(this).siblings(':first');
//   }
//   next.children(':first-child').clone().appendTo($(this));
  
//   for (let i=0;i<minPerSlide;i++) {
//       console.log (i);
//       next=next.next();
//       if (!next.length) {
//         next = $(this).siblings(':first');
//       }
      
//       next.children(':first-child').clone().appendTo($(this));
//     }
// });
