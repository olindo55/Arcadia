export function test(){
    alert('ok');
}

export function validateEmail(input){
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

export function validateRequired(input){
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