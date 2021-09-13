/*Get User Access*/
private = private.replace("3203700", "");
parseInt(private);
/***/


/*System*/
let btnSystem = document.querySelector('.system');
btnSystem.addEventListener('click', function(e){

    if(private < 4){
        e.preventDefault();
        alert('Você não tem permissão para trancar o sistema.');
        return false;
    }

    let action = toggleBtn('Sistema', btnSystem);
    fetch(base_url+'/Painel/controles/system/'+action);
})

/*Reports*/
let btnReports = document.querySelector('.reports');
btnReports.addEventListener('click', function(e){

    if(private < 3){
        e.preventDefault();
        alert('Você não tem permissão para bloquear os reportes.');
        return false;
    }

    let action = toggleBtn('Reportes', btnReports);
    fetch(base_url+'/Painel/controles/reports/'+action);
})

/*Comments*/
let btnComments = document.querySelector('.comments');
btnComments.addEventListener('click', function(e){

    if(private < 3){
        e.preventDefault();
        alert('Você não tem permissão para bloquear os comentários.');
        return false;
    }

    let action = toggleBtn('Comentários', btnComments);
    fetch(base_url+'/Painel/controles/comments/'+action);
})

/*Support*/
let btnSupport = document.querySelector('.support');
btnSupport.addEventListener('click', function(){
    let action = toggleBtn('Suporte', btnSupport);
    fetch(base_url+'/Painel/controles/support/'+action);
})





/*---------------------------------------------Function Helpers------------------------------------------------*/
function toggleBtn(type, btnSystem){
    if(btnSystem.classList.contains('on')){
        btnSystem.classList.remove('on');
        btnSystem.classList.add('off');
        btnSystem.innerHTML = type+': Off';
        return 0;
    }else{
        btnSystem.classList.remove('off');
        btnSystem.classList.add('on');
        btnSystem.innerHTML = type+': On';
        return 1;
    }
}
/*-------------------------------------------------------------------------------------------------------------*/