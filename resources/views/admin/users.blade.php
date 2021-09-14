@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - Usuários
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/users.css" />
@endsection

<!--Content-->
@section('content')

    <form class="search" method="GET">
        <input type="text" name="search" placeholder="Procure por alguem" value="<?=($wantedUser != '') ? $wantedUser : '';?>"/>
        <button><i class="fas fa-search"></i>Procurar</button>
    </form>

    <h1 class="title">
        <i class="fas fa-users"></i>
        <?php if($wantedUser == ''):?>
            Todos os usuários cadastrados
        <?php else: ?>
            <?='Encontramos '.count($users);?>
            <?=(count($users) > 1) ? 'usuários' : 'usuário';?>
            <?=' com "'.$wantedUser.'"';?>
        <?php endif; ?>
    </h1>

    <table>
        <tr>
            <th>
                Id
            </th>
            <th>
                nome
            </th>
            <th>
                Cargo
            </th>
            <th>
                Ações
            </th>
        </tr>
        <?php if(count($users) > 0):?>
            <?php foreach($users as $user): ?>
                <tr>
                    <td>
                        <?=$user['id'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$user['id'];?>"><?=$user['user_name'];?></a>
                    </td>
                    <td>
                        <?=($user['access'] == 1) ? 'Usuário' : '';?>
                        <?=($user['access'] == 2) ? 'Ajudante' : '';?>
                        <?=($user['access'] == 3) ? 'Moderador' : '';?>
                        <?=($user['access'] == 4) ? 'Administrador' : '';?>
                        <?=($user['access'] == 5) ? 'Dono' : '';?>
                    </td>
                    <td>
                        <a class="btn" href="<?=$base_url;?>/Painel/perfil/<?=$user['id'];?>">Ver perfil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php if(count($users) < 1):?>
        <h1 class="empty">
            <?=($wantedUser == '') ? 'Nenhum usuário registrado ainda' : 'Não encontramos nenhum usuário com esse filtro';?>
        </h1>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')

@endsection