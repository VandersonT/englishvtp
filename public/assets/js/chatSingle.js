let btnMenu = document.querySelector('.btnMenu');
let menu = document.querySelector('.menu');
let isOpen = false;

btnMenu.addEventListener('click', function(){
    if(isOpen){
        menu.style.display = 'none';
    }else{
        menu.style.display = 'block';
    }
    isOpen = !isOpen;
})