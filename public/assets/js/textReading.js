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

/*--------------------------------------FILTER_EMPTY_MESSAGE---------------------------------------------------*/
let button = document.querySelector('.mainComment');

button.addEventListener('click', function(e){
    let msg = document.querySelector('.sendnewComment').value;
    if(msg == ''){
        e.preventDefault();
    }
})
/*-------------------------------------------------------------------------------------------------------------*/


/*------------------------------------OPEN_ANSWER_TO_COMMENTS--------------------------------------------------*/
let boxGeneral = document.querySelectorAll('.boxGeneral');
let seeMore = document.querySelectorAll('.seeMore');
let seeLess = document.querySelectorAll('.seeLess');

for(let i = 0; i < seeMore.length; i++){
    seeMore[i].addEventListener('click', function(e){
        boxGeneral[i].style.display = 'block';
        seeMore[i].style.display = 'none';
        seeLess[i].style.display = 'block';
    })
}

for(let i = 0; i < seeLess.length; i++){
    seeLess[i].addEventListener('click', function(e){
        boxGeneral[i].style.display = 'none';
        seeMore[i].style.display = 'block';
        seeLess[i].style.display = 'none';
    })
}
/*-------------------------------------------------------------------------------------------------------------*/


/*---------------------------------SEND_COMMENTS_AND_CLEAN_TEXTAREA--------------------------------------------*/
let btnSubmit = document.querySelectorAll('.button');
let form = document.querySelectorAll('.formNewMsg');
let substitute = document.querySelectorAll('.substitute');

for(let i = 0; i < btnSubmit.length; i++){
    btnSubmit[i].addEventListener('click', function(e){
        e.preventDefault();
        
        let msg = form[i].querySelector('textarea').value;
        form[i].querySelector('textarea').value = '';
        substitute[i].value = msg;
        form[i].submit();
    })
}
/*-------------------------------------------------------------------------------------------------------------*/