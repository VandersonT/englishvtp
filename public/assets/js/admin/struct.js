let btnMobile = document.querySelector('.btnMobile');
let menu = document.querySelector('.box-menu');
let isOpen = true;

btnMobile.addEventListener('click', function(){
    let windowWidth = window.innerWidth;

    if(isOpen){
        menu.style.display = 'none';
        btnMobile.style.left = '0';
    }else{
        menu.style.display = 'block';
        if(windowWidth < 310){
            btnMobile.style.left = '240px';
        }else{
            btnMobile.style.left = '270px';
        }
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
/****/

let btns = document.querySelectorAll('.btnBox');
let boxBtns = document.querySelectorAll('.boxBtns');
let icon = document.querySelectorAll('.btnBox .arrow');

for(let i = 0; i < btns.length; i++){
    btns[i].addEventListener('click', function(){
        if(icon[i].classList.contains('fa-caret-left')){
            /*Close all box-menu*/
            for(let i = 0; i < btns.length; i++){
                boxBtns[i].style.display = 'none';
                icon[i].classList.add('fa-caret-left');
                icon[i].classList.remove('fa-sort-down');
            }
            /*Open the clicked*/
            boxBtns[i].style.display = 'block';
            icon[i].classList.add('fa-sort-down');
            icon[i].classList.remove('fa-caret-left');
        }else{
            /*Close the clicked*/
            boxBtns[i].style.display = 'none';
            icon[i].classList.add('fa-caret-left');
            icon[i].classList.remove('fa-sort-down');
        }

    })
}



for(let i = 0; i < btns.length; i++){
    let sons = boxBtns[i].querySelectorAll('a');
    for(let j = 0; j < sons.length; j++){
        if(sons[j].classList.contains('selected')){
            boxBtns[i].style.display = 'block';
            icon[i].classList.add('fa-sort-down');
            icon[i].classList.remove('fa-caret-left');
        }
    }
}
/*
let sons = boxBtns[i].querySelectorAll('a');

for(let i = 0; i < sons.length; i++){
    if(sons[i].classList.contains('selected')){
        boxBtns[i].style.display = 'block';
        icon[i].classList.add('fa-sort-down');
        icon[i].classList.remove('fa-caret-left');
    }
}
*/