@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - exilados
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/exile.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if(!empty($flash)): ?>
        <h1 class="flash">
            <i class="far fa-check-circle"></i>
            <?=$flash;?>
        </h1>
    <?php endif; ?>

    <form class="search" method="GET">
        <input type="text" name="search" placeholder="Procure por algum usuário" value="<?=($wantedUser != '') ? $wantedUser : '';?>"/>
        <button><i class="fas fa-search"></i>Procurar</button>
    </form>

    <h1 class="title">
        <i class="fas fa-users-cog"></i>
        <?php if($wantedUser == ''):?>
        Usuários Exilados
        <?php else: ?>
            <?='Encontramos '.count($users);?>
            <?=(count($users) > 1) ? 'usuários exilados' : 'usuário exilado';?>
            <?=' com "'.$wantedUser.'"';?>
        <?php endif; ?>
    </h1>
    <br/><br/>
    <a href="<?=$base_url;?>/Painel/exilar" class="registerNew">
        <i class="fas fa-tools"></i>
        Exilar Usuário
    </a>
    <br/><br/>

    <table>
        <tr>
            <th>
                Id
            </th>
            <th>
                nome
            </th>
            <th>
                Responsável
            </th>
            <th>
                Motivo
            </th>
            <th>
                Término
            </th>
            <th>
                Ações
            </th>
        </tr>
        <?php if(count($users) > 0):?>
            <?php foreach($users as $userSingle): ?>
                <tr>
                    <td>
                        <?=$userSingle['user_id'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$userSingle['user_id'];?>"><?=$userSingle['user_name'];?></a>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$userSingle['responsible'];?>"><?=$userSingle['responsible_name'];?></a>
                    </td>
                    <td>
                        <?=$userSingle['reason'];?>
                    </td>
                    <td>
                        <?=($userSingle['time'] == 'eterno') ? 'nunca' : date('d/m/Y H:i', $userSingle['time']) ;?>
                    </td>
                    <td>
                        <a class="btn delete" href="#">Repatriar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <?php if(count($users) < 1):?>
        <h1 class="empty">
            <?=($wantedUser == '') ? 'Nenhum usuário foi exilado até agora' : 'Não encontramos nenhum usuário com esse filtro';?>
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