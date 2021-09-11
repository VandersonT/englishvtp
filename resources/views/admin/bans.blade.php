@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - banidos
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/bans.css" />
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
        Usuários Banidos
        <?php else: ?>
            <?='Encontramos '.count($users);?>
            <?=(count($users) > 1) ? 'usuários banidos' : 'usuário banido';?>
            <?=' com "'.$wantedUser.'"';?>
        <?php endif; ?>
    </h1>
    <br/><br/>
    <a href="<?=$base_url;?>/Painel/novoStaff" class="registerNew">
        <i class="fas fa-tools"></i>
        Banir Usuário
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
                        <a class="btn delete" href="<?=$base_url;?>/Painel/perfil/<?=$userSingle['id'];?>">Desbanir</a>
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
    <script>
        let private = '<?=$user['access'];?>3203700';
    </script>
    <script src="<?=$base_url;?>/assets/js/admin/newStaff.js"></script>
@endsection