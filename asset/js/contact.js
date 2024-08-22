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
    formButton.disabled = false;
  }
  else {
    formButton.disabled = true;
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