import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
});
const spinnerContainer = document.getElementById('spinner-container');

// POST
document.getElementById('btnForm').addEventListener('click', function(event){
  event.preventDefault();
  spinnerContainer.classList.remove('d-none');

  const form = document.getElementById('newServicecontact-form');
  const formData = new FormData(form);

  fetch('/contact/managePostForm', {
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
          const toast = new MyToast(data.message, 'danger');
          toast.show();
      }
  })
  .catch(error => {
      const toast = new MyToast(`Erreur lors de l'envoi: ${error.message}`, 'danger');
      toast.show();
  })
  .finally(() => {
      spinnerContainer.classList.add('d-none');
  });
});

// get the inputs
const inputEmail = document.getElementById('email');
const inputSubject = document.getElementById('subject');
const inputMessage = document.getElementById('message');

// listener the inputs
inputEmail.addEventListener('keyup',validateForm);
inputSubject.addEventListener('keyup',validateForm);
inputMessage.addEventListener('keyup',validateForm);


function validateForm(){
  const emailValid = validateEmail(inputEmail);
  const subjectValid = validateRequired(inputSubject);
  const messageValid = validateRequired(inputMessage);
  
  const formButton = document.getElementById('btnForm');
  if (emailValid && subjectValid && messageValid){
    formButton.disabled = true; /// changer
  }
  else {
    formButton.disabled = false;
  }
}

function validateEmail(input){
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const mailUser = input.value;
  if (mailUser.match(emailRegex)){
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
    return true;
  }
  else {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    return false;
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