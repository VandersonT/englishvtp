@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - banir 
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/banAction.css"  />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($success): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Banido com sucesso</h1>
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
        Banir usuário
    </h1>

    <form class="formBan" method="POST">
        @csrf
        <label>Digite o id do usuário:</label>
        <input class="getId" type="number" name="idToBan" placeholder="Id" />
        
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
            </select>
        </div>

        <div class="box-btn">
            <a href="<?=$base_url;?>/Painel/banidos">Ver lista</a>
            <button>Banir</button>
        </div>
    </form>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.js"></script>
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

    </script>
@endsection