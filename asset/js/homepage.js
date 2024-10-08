import Service from './class/Service.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';


document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
});
const spinnerContainer = document.getElementById('spinner-container');

// Swiper for carousel
//--------------------
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
  

// select stars
//--------------
  const stars = document.querySelectorAll('.my-star');
  const ratingValue = document.getElementById('ratingValue');

  stars.forEach(star => {
      star.addEventListener('click', function() {
          ratingValue.value = this.getAttribute('data-value');
          highlightStars(ratingValue.value);
          validateForm();
      });
  });

  function highlightStars(rating) {
      stars.forEach(star => {
          star.classList.remove('selected');
          if (star.getAttribute('data-value') <= rating) {
              star.classList.add('selected');
          }
      });
  }

// validation comment
//-------------------
// get the inputs
const inputPseudo = document.getElementById('pseudo');
const inputComment = document.getElementById('comment');

// listener the inputs
inputPseudo.addEventListener('keyup',validateForm);
inputComment.addEventListener('keyup',validateForm);


function validateForm(){
  const pseudoValid = validateRequired(inputPseudo);
  const commentValid = validateRequired(inputComment);
  const starsValid = validateStars(ratingValue);
  
  const formButton = document.getElementById('btn-form-comment');
  if (pseudoValid && commentValid && starsValid){
    formButton.disabled = false;
  }
  else {
    formButton.disabled = true;
  }
}

function validateRequired(input){
  if (input.value == ''){
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    return false;
  }
  else {
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
    return true;
  }
}

function validateStars(input){
  if (input.value == '0'){
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    return false;
  }
  else {
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
    return true;
  }
}


// POST Comment
//-------------------
document.getElementById('btn-form-comment').addEventListener('click', function(event){
  event.preventDefault();
  spinnerContainer.classList.remove('d-none');

  const form = document.getElementById('form-comment');
  const formData = new FormData(form);

  fetch('/homepage/post', {
      method: 'POST',
      body: formData
  })
  .then(response => {
      if (!response.ok) {
          const toast = new MyToast('Page non disponible', 'danger');
          toast.show();
      } else {
          return response.json();
      }
  })
  .then(data => {
      if (data.success) {
          const toast = new MyToast(data.message, 'success');
          toast.show();
      } 
      else {
          const toast = new MyToast('Erreur lors de l\'envoie du commentaire', 'danger');
          toast.show();
      }
  })
  .catch(error => {
      const toast = new MyToast(`Erreur lors de l\'envoie du commentaire: ${error.message}`, 'danger');
      toast.show();
  })
  .finally(() => {
      spinnerContainer.classList.add('d-none');
      form.addEventListener('reset',function(){
        validateForm;
        stars.forEach(star => {star.classList.remove('selected');});
        formButton.disabled = true;

      });
      form.reset();
  });
});