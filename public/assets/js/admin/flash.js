let btnCloses = document.querySelector('.btn');
let flash = document.querySelector('.backgroundDark');

if(flash){
    btnCloses.addEventListener('click', function(e){
        e.preventDefault();
        flash.style.display = 'none';
    })
}