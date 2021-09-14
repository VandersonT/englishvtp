@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - Notificação
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/userNotification.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($success): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Alteração feita</h1>
            <p><?=$success;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($error): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="error">Alteração negada</h1>
            <p><?=$error;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <div class="view">

        <form method="POST" action="<?=$base_url;?>/Painel/enviaNotificação">
            @csrf
            <label>Para quem será a mensagem?</label>
            
            <input min="0" type="number" name="user_to" />

            <label>Qual a cor da mensagem?</label>

            <select name="color" required>
                <option value="green" class="green">Verde</option>
                <option value="blue" class="blue">Azul</option>
                <option value="yellow" class="yellow">Amarelo</option>
                <option value="red" class="red">Vermelho</option>
            </select>

            <label>Qual o titulo?</label>
            <input type="text" name="title"/>

            <label>Qual a mensagem?</label>

            <textarea name="content"></textarea>

            <button>Enviar</button>
        </form>
        <a href="<?=$base_url;?>/" class="config"><i class="fas fa-tools"></i></a>

    </div>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.js"></script>
@endsection