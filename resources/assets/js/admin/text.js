let btnHelp = document.querySelector('.helpme');

btnHelp.addEventListener('click', function(){
    document.querySelector('.help').style.display = 'block';
})

let btnClose = document.querySelector('.btnClose');

btnClose.addEventListener('click', function(){
    document.querySelector('.help').style.display = 'none';
})