let btnMobile = document.querySelector('.btnMobile');
let menu = document.querySelector('.box-menu');
let isOpen = true;

btnMobile.addEventListener('click', function(){
    if(isOpen){
        menu.style.display = 'none';
        btnMobile.style.left = '0';
    }else{
        menu.style.display = 'block';
        btnMobile.style.left = '270px';
    }
    isOpen = !isOpen;
})

window.onresize = function(){
    let windowWidth = window.innerWidth;
    if(windowWidth >= 1200){
        menu.style.display = 'block';
        btnMobile.style.left = '270px';
        isOpen = true;
    }
}