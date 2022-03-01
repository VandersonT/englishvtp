let needConfirm = true;

let formText = document.querySelector('.formText button');

formText.addEventListener('click', function(){
    needConfirm = false;
})

window.onbeforeunload = confirmExit;
function confirmExit(){
    if(needConfirm){
        return "Deseja realmente sair desta página?";
    }
    needConfirm = true;
}