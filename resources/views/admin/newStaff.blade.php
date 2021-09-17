@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - usuários
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/newStaff.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.css" />
@endsection

<!--Content-->
@section('content')

<h1 class="mainTitle">
    <i class="fas fa-user-shield"></i>
    Gerenciar cargos dos membros
</h1>

<form class="search" method="GET">
    <h1 class="title2">Procure por algum usuário</h1>
    <label>
        <input type="number" name="idSearch" placeholder="ID" value="<?=($idSearch != 0) ? $idSearch : '';?>"/>
        <button><i class="fas fa-search"></i></button>
    </label>
</form>

<?php if($userFound == ''):?>
    <h1 class="title">
        <i class="fas fa-users"></i>
        Nenhum usuário pesquisado
    </h1>
<?php endif; ?>

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

<?php if(!empty($userFound)):?>
    <div class="userFound">
        <h1 class="title2 ciano">
            <i class="fab fa-searchengin"></i>
            Usuário encontrado:
        </h1>
        <br/>
        <img class="photo" src="<?=$base_url;?>/media/avatars/<?=$userFound['photo'];?>" />
        <div class="info">
            <p>
                <b>Nome:</b>
                <?=$userFound['user_name'];?>
                <b><?=($userFound['id'] == $user['id']) ? '[você]' : '';?></b>
            </p>
            <p>
                <b>Email:</b>
                <?=$userFound['email'];?>
            </p>
            <p>
                <b>Cargo:</b>
                <?=($userFound['access'] == 1) ? 'Usuário' : '';?>
                <?=($userFound['access'] == 2) ? 'Ajudante' : '';?>
                <?=($userFound['access'] == 3) ? 'Moderador' : '';?>
                <?=($userFound['access'] == 4) ? 'Administrador' : '';?>
                <?=($userFound['access'] == 5) ? 'Dono' : '';?>
            </p>
            <p>
                <b>Level:</b>
                <?=($userFound['level'] != NULL) ? $userFound['level'] : 'Desconhecido';?>
            </p>
        </div>
        <form class="saveInfo" method="POST" action="<?=$base_url;?>/Painel/mudarAcesso/<?=$userFound['id'];?>">
            @csrf
            <select name="newAccess">
                <option <?=($userFound['access'] == 1) ? 'selected' : '';?> value="1">Usuário</option>
                <option <?=($userFound['access'] == 2) ? 'selected' : '';?> value="2">Ajudante</option>
                <option <?=($userFound['access'] == 3) ? 'selected' : '';?> value="3">Moderador</option>
                <?php if($user['access'] > 4): ?>
                    <option <?=($userFound['access'] == 4) ? 'selected' : '';?> value="4">Administrador</option>
                    <option <?=($userFound['access'] == 5) ? 'selected' : '';?> value="5">Dono</option>
                <?php endif; ?>
            </select>

        <div class="box-btn">
            <a href="<?=$base_url;?>/Painel/staffs">Ver lista</a>
            <button>Salvar</button>
        </div>

        </form>
    </div>
<?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.js"></script>
@endsection