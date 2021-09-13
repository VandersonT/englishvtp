let btnSuggestion = document.querySelector('.btnAssistent');
let assistentIsOpen = false;

btnSuggestion.addEventListener('click', function(){

    if(assistentIsOpen){
        document.querySelector('.assistent').style.display = 'none';
        document.querySelector('.assistentTalk').style.display = 'none';
    }else{
        document.querySelector('.assistent').style.display = 'block';
        setTimeout(function(){
            document.querySelector('.assistentTalk').style.display = 'block';
        }, 1000)
    }
    assistentIsOpen = !assistentIsOpen;
})