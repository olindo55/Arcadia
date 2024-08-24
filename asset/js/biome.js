const biomeCards = document.querySelectorAll('.accordion-biome-card');

biomeCards.forEach(myBiomeCard => {
    myBiomeCard.addEventListener("click", function() {
        myBiomeCard.parentElement.classList.toggle('clicked');
    });
});
