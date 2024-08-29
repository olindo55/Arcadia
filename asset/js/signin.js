// get the inputs
const inputLogin = document.getElementById('username');
const inputPassword = document.getElementById('password');
const btnSignin = document.getElementById('btnForm');

// listeners
inputLogin.addEventListener('keyup', validateForm);
inputPassword.addEventListener('keyup', validateForm);
btnSignin.addEventListener("click", checkCredentials);


function validateForm(){
    const loginValid = validateEmail(inputLogin);
    const passwordValid = validateRequired(inputPassword);
    
    if (loginValid && passwordValid){
        btnSignin.disabled = false;
    }
    else {
        btnSignin.disabled = true;
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

// function checkCredentials(){
//     //Ici, il faudra appeler l'API pour vérifier les credentials en BDD

//     if(inputLogin.value == "admin@arcadia.com" && inputPassword.value == "123"){
//         //Il faudra récupérer le vrai token
//         const token = "lkjsdngfljsqdnglkjsdbglkjqskjgkfjgbqslkfdgbskldfgdfgsdgf";
//         setToken(token);
//         setCookie(RoleCookieName, "admin", 7);
//         window.location.replace("/");
//     }
//     else{
//         inputLogin.value = "";
//         inputLogin.classList.remove('is-valid');
//         inputLogin.classList.add('is-invalid');
//         inputPassword.value = "";
//         inputPassword.classList.remove('is-valid');
//         inputPassword.classList.add('is-invalid');
  
//         let errorMessage = document.getElementById('error-message');
//         if (!errorMessage) {
//           errorMessage = document.createElement('div');
//           errorMessage.id = 'error-message';
//           errorMessage.className = 'alert alert-danger mt-3';
//           errorMessage.textContent = "Identifiant et/ou mot de passe invalides !";
//           document.getElementById('signin-form').appendChild(errorMessage);
//         }
//     }  
// }



// // token
// const tokenCookieName = "accesstoken";

// function setToken(token){
//     setCookie(tokenCookieName, token, 7);
// }

// function getToken(){
//     return getCookie(tokenCookieName);
// }



// // cookies
// function setCookie(name,value,days) {
//     var expires = "";
//     if (days) {
//         var date = new Date();
//         date.setTime(date.getTime() + (days*24*60*60*1000));
//         expires = "; expires=" + date.toUTCString();
//     }
//     document.cookie = name + "=" + (value || "")  + expires + "; path=/";
// }

// function getCookie(name) {
//     var nameEQ = name + "=";
//     var ca = document.cookie.split(';');
//     for(var i=0;i < ca.length;i++) {
//         var c = ca[i];
//         while (c.charAt(0)==' ') c = c.substring(1,c.length);
//         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
//     }
//     return null;
// }

// function eraseCookie(name) {   
//     document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
// }

// const RoleCookieName = "role";

// function getRole(){
//     return getCookie(RoleCookieName);
// }