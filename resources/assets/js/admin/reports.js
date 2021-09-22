/*Get User Access*/
private = private.replace("3203700", "");
parseInt(private);
/***/


/*check if access is greater than 3 to see reports*/
let btnSeeReports = document.querySelectorAll('.seeReports');

for(let i = 0; i < btnSeeReports.length; i++){
    btnSeeReports[i].addEventListener('click', function(e){
        if(private < 3){
            e.preventDefault();
            alert('Somente moderadores, administradores e donos podem acessar essa página.');
        }
    })
}
/***/