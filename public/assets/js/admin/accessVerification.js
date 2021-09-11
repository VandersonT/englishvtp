/*Get User Access*/
private = private.replace("3203700", "");
parseInt(private);
/***/

/*check if access is greater than 4 to access a page*/
let registerNew = document.querySelector('.registerNew');

registerNew.addEventListener('click', function(e){
    if(private < 4){
        e.preventDefault();
        alert("Somente administradores e donos podem acessar essa página.");
    }
});
/***/

/*check if access is greater than 4 to unban someone*/
let btnRemoveBan = document.querySelectorAll('.delete');

for(let i = 0; i < btnRemoveBan.length; i++){
    btnRemoveBan[i].addEventListener('click', function(e){
        if(private < 4){
            e.preventDefault();
            alert('Somente administradores e donos podem desfazer um ban.');
        }
    })
}
/***/