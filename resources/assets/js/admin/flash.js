let btnCloses = document.querySelectorAll('.btn');
let flash = document.querySelectorAll('.backgroundDark');

for(let i = 0; i < btnCloses.length; i++){
    if(flash[i]){
        btnCloses[i].addEventListener('click', function(e){
            e.preventDefault();
            flash[i].style.display = 'none';
        })
    }
}