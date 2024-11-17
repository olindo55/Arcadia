
document.addEventListener('DOMContentLoaded', function() {
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
      navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
      },
  });
});

// Gestionnaire de clics 
document.addEventListener('click', function(e) {
  const likeButton = e.target.closest('.like');
  const thumbsUpIcon = e.target.matches('.like i.bi-hand-thumbs-up-fill');

  if (thumbsUpIcon && likeButton && !likeButton.classList.contains('clicked')) {
      e.preventDefault();
      e.stopPropagation();


      const carouselCard = e.target.closest('.carrousel-animal-card');
      const accordionItem = e.target.closest('.accordion-item');
      
      let animalName;
      if (carouselCard) {
          // For carousel
          animalName = carouselCard.querySelector('h2').textContent.trim();
      } else if (accordionItem) {
          // For accordion
          animalName = accordionItem.querySelector('.accordion-button').textContent.trim();
      }

      if (animalName) {
          fetch(`/biome/addClick`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({name: animalName})
          })
          .then(response => {
              document.querySelectorAll('.like').forEach(like => {
                  const cardName = like.closest('.carrousel-animal-card')?.querySelector('h2')?.textContent.trim() ||
                                 like.closest('.accordion-item')?.querySelector('.accordion-button')?.textContent.trim();
                  
                  if (cardName === animalName) {
                      like.classList.add('clicked');
                      const icon = like.querySelector('i.bi-hand-thumbs-up-fill');
                      if (icon) {
                          icon.classList.add('clicked');
                          setTimeout(() => {
                              icon.classList.remove('clicked');
                          }, 500);
                      }
                  }
              });
              
              return response.json();
          })
          .then(data => {
              console.log('Données reçues:', data);
              if (data.error) {
                  console.error('Erreur:', data.error);
              }
          })
          .catch(error => {
              console.error('Erreur:', error);
          });
      }
  }
});