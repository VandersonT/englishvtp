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
    
    <form class="search" method="GET">
        <input type="text" name="search" placeholder="Procure por algum staff" value="<?=($wantedUser != '') ? $wantedUser : '';?>"/>
        <button><i class="fas fa-search"></i>Procurar</button>
    </form>

    <h1 class="title">
        <i class="fas fa-users-cog"></i>
        <?php if($wantedUser == ''):?>
            Membros da staffs
        <?php else: ?>
            <?='Encontramos '.count($staffs);?>
            <?=(count($staffs) > 1) ? 'usuários' : 'usuário';?>
            <?=' da staff com "'.$wantedUser.'"';?>
        <?php endif; ?>
    </h1>
    <br/><br/>
    <a href="<?=$base_url;?>/Painel/novoStaff" class="registerNew">
        <i class="fas fa-tools"></i>
        Gerenciar cargos
    </a>
    <br/><br/>

    <table>
        <tr>
            <th class="staffColor">
                Id
            </th>
            <th class="staffColor">
                nome
            </th>
            <th class="staffColor">
                Cargo
            </th class="staffColor">
            <th class="staffColor">
                Ações
            </th>
        </tr>
        <?php if(count($staffs) > 0):?>
            <?php foreach($staffs as $staff): ?>
                <tr>
                    <td>
                        <?=$staff['id'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$staff['id'];?>"><?=$staff['user_name'];?></a>
                    </td>
                    <td>
                        <?=($staff['access'] == 2) ? 'Ajudante' : '';?>
                        <?=($staff['access'] == 3) ? 'Moderador' : '';?>
                        <?=($staff['access'] == 4) ? 'Administrador' : '';?>
                        <?=($staff['access'] == 5) ? 'Dono' : '';?>
                    </td>
                    <td>
                        <a class="btn" href="<?=$base_url;?>/Painel/perfil/<?=$staff['id'];?>">Ver perfil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <?php if(count($staffs) < 1):?>
        <h1 class="empty">
            <?=($wantedUser == '') ? 'Nenhum usuário registrado ainda' : 'Não encontramos nenhum usuário com esse filtro';?>
        </h1>
    <?php endif; ?>
@endsection

<!--Scripts-->
@section('scripts')
    <script>
        let private = '<?=$user['access'];?>3203700';
    </script>
    <script src="<?=$base_url;?>/assets/js/admin/accessVerification.js"></script>
@endsection