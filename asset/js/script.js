

// burger menu
const burgerMenuButton = document.querySelector('.my-burger-button')
const burgerMenuButtonIcon = document.querySelector('.my-burger-button i')
const burgerMenu = document.querySelector('.my-burger-menu')
burgerMenuButton.onclick = function(){
    burgerMenu.classList.toggle('open')
    const isOpen = burgerMenu.classList.contains('open')
    burgerMenuButtonIcon.classList = isOpen ? 'bi bi-x text-light' : 'bi bi-list text-light'
}

// active management
document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('nav li');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            menuItems.forEach(li => li.classList.remove('active'));
            this.classList.add('active');
        });
    });
});