"use strict";



function loginForm() {

    let userLogin = document.getElementById('userLogin');
    let userLoginLength = userLogin.value.length >= 5 && userLogin.value.length <= 8;

    let userLoginCorrect = userLogin.value.includes('rua') || userLogin.value.includes('ost') || userLogin.value.includes('adm');
    let userLoginNotMail = userLogin.value.includes('@');

    if (userLoginLength) {
    } else {
        alert('Длина логина неверна');
        return false;
    }

    if (userLoginCorrect) {
    } else {
        alert('Ваш логин должен быть rua* или ost*');
        return false;
    }

    if (!userLoginNotMail) {
    } else {
        alert('Email вводить не нужно :)');
        return false;
    }

}
loginForm();