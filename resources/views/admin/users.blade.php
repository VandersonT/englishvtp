@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - usuários
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/users.css" />
@endsection

<!--Content-->
@section('content')

    <form class="search" method="POST">
        <input type="text" placeholder="Procure por alguem" />
        <button><i class="fas fa-search"></i>Procurar</button>
    </form>

    <h1 class="title">
        <i class="fas fa-users"></i>
        Todos os usuários cadastrados
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
                        <?=$user['user_name'];?>
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

@endsection

<!--Scripts-->
@section('scripts')

@endsection