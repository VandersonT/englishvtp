/*--------------------------------------------LIKE-------------------------------------------------------------*/
let btnLike = document.querySelectorAll('.btnLike');
let numberLike = document.querySelectorAll('.numberLike');

for(let i = 0; i < btnLike.length; i++){
    btnLike[i].addEventListener('click', function(e){
        e.preventDefault();

        let id =  btnLike[i].closest('.boxCommentSingle').getAttribute('data-id');
        let type =  btnLike[i].closest('.boxCommentSingle').getAttribute('typec');

        if(btnUnlike[i].classList.contains('unliked')){
            btnUnlike[i].click();
        }

        like = numberLike[i].innerText;
        like = parseInt(like);

        if(btnLike[i].classList.contains('liked')){
            btnLike[i].classList.remove('liked');
            numberLike[i].innerHTML = like - 1;
        }else{
            btnLike[i].classList.add('liked');
            numberLike[i].innerHTML = like + 1;
        }

        fetch(base_url+'/ajax/rate/'+id+'/1/'+type);

    })
}
/*-------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------UNLIKE-------------------------------------------------------------*/
let btnUnlike = document.querySelectorAll('.btnUnlike');
let numberUnlike  = document.querySelectorAll('.numberUnlike');

for(let i = 0; i < btnLike.length; i++){
    btnUnlike[i].addEventListener('click', function(e){
        e.preventDefault();

        let id =  btnLike[i].closest('.boxCommentSingle').getAttribute('data-id');
        let type =  btnLike[i].closest('.boxCommentSingle').getAttribute('typec');

        unlike = numberUnlike[i].innerText;
        unlike = parseInt(unlike);

        if(btnLike[i].classList.contains('liked')){
            btnLike[i].click();
        }

        if(btnUnlike[i].classList.contains('unliked')){
            btnUnlike[i].classList.remove('unliked');
            numberUnlike[i].innerHTML = unlike - 1;
        }else{
            btnUnlike[i].classList.add('unliked');
            numberUnlike[i].innerHTML = unlike + 1;
        }

        fetch(base_url+'/ajax/rate/'+id+'/-1/'+type);

    })
}
/*-------------------------------------------------------------------------------------------------------------*/