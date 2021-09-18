let allMenu = document.querySelector('.menu');

allMenu.addEventListener('click', function(e){
    if(!confirm('Se você sair perderá toda a edição!')){
        e.preventDefault();
    }
})