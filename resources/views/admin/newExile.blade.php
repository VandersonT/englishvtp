@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - exilar 
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/exileAction.min.css"  />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.min.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($success): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Exilado com sucesso</h1>
            <p><?=$success;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($error): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="error">Ação negada</h1>
            <p><?=$error;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <h1 class="title">
        <i class="fas fa-ban"></i>
        Exilar usuário
    </h1>

    <form class="formExile" method="POST">
        @csrf
        <label>Digite o id do usuário:</label>
        <input class="getId" type="number" name="idToExile" placeholder="Id" />
        
        <label>Digite o motivo:</label>
        <textarea name="reason"></textarea>
        
        <label>Digite quanto tempo:</label>
        <div>
            <input class="getId time" type="number" name="time" />
            <select class="formTime" name="formTime">
                <option>Hora</option>
                <option>Dia</option>
                <option>Mês</option>
                <option>Ano</option>
                <option>Eterno</option>
            </select>
        </div>

        <div class="box-btn">
            <a href="<?=$base_url;?>/Painel/exilio">Ver lista</a>
            <button>Exilar</button>
        </div>
    </form>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
    <script>
        let btnTime = document.querySelector('.time');
        let options = document.querySelectorAll('.formTime option');

        btnTime.addEventListener('keyup', function(){
            if(btnTime.value > 1){
                options[0].innerHTML = 'Horas';
                options[1].innerHTML = 'Dias';
                options[2].innerHTML = 'Meses';
                options[3].innerHTML = 'Anos';
            }else{
                options[0].innerHTML = 'Hora';
                options[1].innerHTML = 'Dia';
                options[2].innerHTML = 'Mês';
                options[3].innerHTML = 'Ano';
            }
        })

        let select = document.querySelector('.formTime');
        let time = document.querySelector('.time');
        select.addEventListener('click', function(){
            if(select.value == 'Eterno'){
                time.disabled = true;
                time.value = '';
            }else{
                time.disabled = false;
            }
        })

    </script>
@endsection