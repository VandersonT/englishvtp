@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - Gerenciar notificações
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/managerNotification.min.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.min.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($flash): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Removido com sucesso</h1>
            <p><?=$flash;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <form class="search" method="GET">
        <input type="text" name="search" placeholder="Procure pelo nome ou id de algum usuário" value="<?=($wantedNotification != '') ? $wantedNotification : '';?>"/>
        <button><i class="fas fa-search"></i>Procurar</button>
    </form>

    <h1 class="title">
        <i class="fas fa-users-cog"></i>
        <?php if($wantedNotification == ''):?>
        Usuários Notificados
        <?php else: ?>
            <?='Encontramos '.count($notifications);?>
            <?=(count($notifications) > 1) ? 'avisos' : 'aviso';?>
            <?=' para usuários com o filtro "'.$wantedNotification.'"';?>
        <?php endif; ?>
    </h1>

    <table>
        <tr>
            <th>
                Pelo staff
            </th>
            <th>
                para usuário
            </th>
            <th>
                titulo
            </th>
            <th>
                Mensagem
            </th>
            <th>
                Ação
            </th>
        </tr>
        <?php if(count($notifications) > 0):?>
            <?php foreach($notifications as $notification): ?>
                <tr>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$notification['staff_id'];?>"><?=$notification['responsible_name'];?></a>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$notification['user_to'];?>"><?=$notification['user_name'];?></a>
                    </td>
                    <td>
                        <?=$notification['title'];?>
                    </td>
                    <td>
                        <?=$notification['message'];?>
                    </td>
                    <td>
                        <a onClick="return confirm('Você tem certeza que quer remover esta notificação?');" href="<?=$base_url;?>/Painel/removeNotificação/<?=$notification['id'];?>">Apagar</a>
                    </td>
                </tr>
                
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    
    <?php if(count($notifications) < 1):?>
        <h1 class="empty">
            <?=($wantedNotification == '') ? 'Nenhum aviso foi enviado para algum usuário ainda' : 'Nenhum aviso para este filtro encontrado';?>
        </h1>
    <?php endif; ?>


    <h1 class="title">
        <i class="fas fa-globe-europe"></i>
        Notificações globais
    </h1>

    <table>
        <tr>
            <th>
                Pelo staff
            </th>
            <th>
                titulo
            </th>
            <th>
                Mensagem
            </th>
            <th>
                Ação
            </th>
        </tr>
        <?php if(count($globalNotifications) > 0):?>
            <?php foreach($globalNotifications as $globalNotification): ?>
                <tr>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$globalNotification['staff_id'];?>"><?=$globalNotification['responsible_name'];?></a>
                    </td>
                    <td>
                        <?=$globalNotification['title'];?>
                    </td>
                    <td>
                        <?=$globalNotification['message'];?>
                    </td>
                    <td>
                        <a onClick="return confirm('Você tem certeza que quer remover esta notificação?');" href="<?=$base_url;?>/Painel/removeNotificação/<?=$globalNotification['id'];?>">Apagar</a>
                    </td>
                </tr>
                
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php if(count($globalNotifications) < 1):?>
        <h1 class="empty">Não foi enviado nenhuma notificação global ainda</h1>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
@endsection