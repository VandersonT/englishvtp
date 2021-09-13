let btnMobile = document.querySelector('.btnMobile');
let menuIsOpen = false;


btnMobile.addEventListener('click', function(){
    
    if(notificationIsOpen){
        btnNotification.click();
    }
    
    if(menuIsOpen){
        document.querySelector('.menuMobile').style.display = "none";
    }else{
        document.querySelector('.menuMobile').style.display = "block";
    }
    menuIsOpen = !menuIsOpen;
})

window.onresize = function(){
    if(menuIsOpen){
        menuIsOpen = !menuIsOpen;
        document.querySelector('.menuMobile').style.display = "none";
    }
}


let btnNotification = document.querySelector('.bell');
let notificationIsOpen = false;
btnNotification.addEventListener('click', function(){
    
    if(menuIsOpen){
        btnMobile.click();
    }
    
    if(notificationIsOpen){
        document.querySelector('.notification').style.display = "none";
    }else{
        document.querySelector('.notification').style.display = "block";
    }
    notificationIsOpen = !notificationIsOpen;
})


let openNot = document.querySelectorAll('.notificationSingle');

for(let i = 0; i < openNot.length; i++){
    openNot[i].addEventListener('click', function(){

        console.log(base_url);
        let id =  openNot[i].closest('.notificationSingle').getAttribute('dataId');

        

        fetch(base_url+'/viewedNotification/'+id);
        
    })
}