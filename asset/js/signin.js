import MyToast from './class/MyToast.js';

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
});
const spinnerContainer = document.getElementById('spinner-container');

// signin
document.getElementById('login-button')
    .addEventListener('click', function(event){
        event.preventDefault();
        spinnerContainer.classList.remove('d-none');

        const form = document.getElementById('login-form');
        const formData = new FormData(form);
    
        fetch('/login/check', {
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
                window.location.href = '/homepage/view';
            } 
            else {
                const toast = new MyToast(data.message, 'danger');
                toast.show();
            }
        })
        .catch(error => {
            const toast = new MyToast(`Erreur lors de  la connexion`, 'danger');
            toast.show();
        })
        .finally(() => {
            spinnerContainer.classList.add('d-none');
        });
    });


// // // token
// // const tokenCookieName = "accesstoken";

// // function setToken(token){
// //     setCookie(tokenCookieName, token, 7);
// // }

// // function getToken(){
// //     return getCookie(tokenCookieName);
// // }



// // // cookies
// // function setCookie(name,value,days) {
// //     var expires = "";
// //     if (days) {
// //         var date = new Date();
// //         date.setTime(date.getTime() + (days*24*60*60*1000));
// //         expires = "; expires=" + date.toUTCString();
// //     }
// //     document.cookie = name + "=" + (value || "")  + expires + "; path=/";
// // }

// // function getCookie(name) {
// //     var nameEQ = name + "=";
// //     var ca = document.cookie.split(';');
// //     for(var i=0;i < ca.length;i++) {
// //         var c = ca[i];
// //         while (c.charAt(0)==' ') c = c.substring(1,c.length);
// //         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
// //     }
// //     return null;
// // }

// // function eraseCookie(name) {   
// //     document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
// // }

// // const RoleCookieName = "role";

// // function getRole(){
// //     return getCookie(RoleCookieName);
// // }