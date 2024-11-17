
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

    if (e.target.matches('.carrousel-animal-card .like i.bi-hand-thumbs-up-fill') && 
    !e.target.closest('.like').classList.contains('clicked')) {
        e.preventDefault();
        e.stopPropagation();

        const animalCard = e.target.closest('.carrousel-animal-card');
        const titleElement = animalCard.querySelector('h2');
        const animalName = titleElement.textContent.trim();

        fetch(`/biome/addClick`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({name: animalName})
        })
        .then(response => {
          const likeElement = e.target.closest('.like');
          if (likeElement) {
              likeElement.classList.add('clicked');
          }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            if (data.error) {
                console.error('Erreur:', data.error);
            } else {
                e.target.classList.add('clicked');
                setTimeout(() => {
                    e.target.classList.remove('clicked');
                }, 500);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
});
