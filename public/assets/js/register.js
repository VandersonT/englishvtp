/*Show Password*/
let btnShowPass = document.querySelector('.showPassword');
let isVisible = false;

let fieldPass = document.getElementById('pass');
let fieldConfirmPass = document.getElementById('confirmPass');

btnShowPass.addEventListener('click', function(){
    if(isVisible){
        fieldPass.type = 'password';
        fieldConfirmPass.type = 'password';
        isVisible = !isVisible;
    }else{
        fieldPass.type = 'text';
        fieldConfirmPass.type = 'text';
        isVisible = !isVisible;
    }
})
/***/