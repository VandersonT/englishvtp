let btnCloses = document.querySelectorAll('.btn');
let flash = document.querySelectorAll('.backgroundDark');

for(let i = 0; i < btnCloses.length; i++){
    if(flash[i]){
        btnCloses[i].addEventListener('click', function(e){
            e.preventDefault();
            flash[i].style.display = 'none';

            let user_to =  flash[i].closest('.backgroundDark').getAttribute('userTo');
            
            if(user_to > 0){
                let idNotification =  flash[i].closest('.backgroundDark').getAttribute('private');
                fetch(base_url+'/removeNotificação/'+idNotification);
            }

        })
    }
}