/*-------------------------------------------ActiveSubComment--------------------------------------------------*/
let btnSubComment = document.querySelectorAll('.btnActiveComment');
let isOpen = [];

for(let i = 0; i < btnSubComment.length; i++){

    btnSubComment[i].addEventListener('click', function(event){
    
        let subCommentSingle = document.querySelectorAll('.subNewComment')[i];

        if(isOpen[i]){
            subCommentSingle.style.display = "none";
            isOpen[i] = false;
        }else{
            subCommentSingle.style.display = "flex";
            isOpen[i] = true;
        }
        
    
    })

}
/*-------------------------------------------------------------------------------------------------------------*/

/*---------------------------------------------Assistent-------------------------------------------------------*/
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
/*-------------------------------------------------------------------------------------------------------------*/

/*-------------------------------------------Flash_Message-----------------------------------------------------*/

let closeFlash = document.querySelector('.flash button');

if(closeFlash){
    closeFlash.addEventListener('click', function(){
        document.querySelector('.flash').style.display = 'none';
    }) 
}
/*-------------------------------------------------------------------------------------------------------------*/

let button = document.querySelectorAll('.button');

for(let i = 0; i < button.length; i++){
    button[i].addEventListener('click', function(e){
        let comment = document.querySelector('.sendnewComment').value;

        if(comment == ''){
            e.preventDefault();
        }
    })
}
