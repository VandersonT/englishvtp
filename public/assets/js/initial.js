let openMenuMobile = document.querySelector('.openMenuMobile');
let closeMenuMobile = document.querySelector('.closeMenuMobile');

openMenuMobile.addEventListener('click', function(){
    closeMenuMobile.style.display = "block";
    document.querySelector('.menuMobile').style.display = "flex";
})

closeMenuMobile.addEventListener('click', function(){
    closeMenuMobile.style.display = "none";
    document.querySelector('.menuMobile').style.display = "none";
})


window.onresize = function(){
    let windowWidth = window.innerWidth;

    if(windowWidth > 800){
        closeMenuMobile.style.display = "none";
        document.querySelector('.menuMobile').style.display = "none";
    }
 };