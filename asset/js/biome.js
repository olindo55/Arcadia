const biomeCards = document.querySelectorAll('.accordion-biome-card');

biomeCards.forEach(myBiomeCard => {
    myBiomeCard.addEventListener("click", function() {
        myBiomeCard.parentElement.classList.toggle('clicked');
    });
});

const animalCards = document.querySelectorAll('.carrousel-animal-card');

animalCards.forEach(myAnimalCard => {
    myAnimalCard.addEventListener("click", function() {
        myAnimalCard.classList.toggle('clicked');
    });
});

