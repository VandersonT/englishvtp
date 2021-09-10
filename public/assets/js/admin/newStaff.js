let registerNew = document.querySelector('.registerNew');

private = private.replace("3203700", "");

parseInt(private);

registerNew.addEventListener('click', function(e){
    if(private < 4){
        e.preventDefault();
        alert("Somente administradores e donos podem acessar essa pagina.");
    }
});