@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - usuários
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/newStaff.css" />
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
            </p>
            <p>
                <b>Email:</b>
                <?=$userFound['email'];?>
            </p>
            <p>
                <b>Level:</b>
                <?=($userFound['level'] != NULL) ? $userFound['level'] : 'Desconhecido';?>
            </p>
        </div>
        <form class="saveInfo" method="POST" action="<?=$base_url;?>/">
            <select>
                <option <?=($userFound['access'] == 1) ? 'selected' : '';?>>Usuário</option>
                <option <?=($userFound['access'] == 2) ? 'selected' : '';?>>Ajudante</option>
                <option <?=($userFound['access'] == 3) ? 'selected' : '';?>>Moderador</option>
                <option <?=($userFound['access'] == 4) ? 'selected' : '';?>>Administrador</option>
                <option <?=($userFound['access'] == 5) ? 'selected' : '';?>>Dono</option>
            </select>
            <button>Salvar</button>
        </form>
    </div>
<?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')

@endsection