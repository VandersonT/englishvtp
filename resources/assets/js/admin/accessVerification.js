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
let btnRemovePunishment = document.querySelectorAll('.delete');

for(let i = 0; i < btnRemovePunishment.length; i++){
    btnRemovePunishment[i].addEventListener('click', function(e){
        let actionName = btnRemovePunishment[i].innerText.toLowerCase();
        if(private < 4){
            e.preventDefault();
            if(actionName == 'repatriar'){
                alert('Somente administradores e donos podem desfazer um exilio.');
            }else{
                alert('Somente administradores e donos podem desfazer um ban.');
            }
        }else{
            if(!confirm('Você tem certeza que quer '+actionName+' este usuário?')){
                e.preventDefault();
            }
        }
    })
}
/***/