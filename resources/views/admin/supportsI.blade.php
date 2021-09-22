@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
    Painel - Suportes ignorados
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/supports.min.css" />
@endsection

<!--Content-->
@section('content')
    <div class="note ignoredColor">
        <h1><i class="far fa-sticky-note"></i>Sobre os Ignorados:</h1>
        <p>Aqui ficam os comentários que ainda não foram analizados por ninguém da staff, se você possui o cargo de moderador ou superior, você pode analizalos e tomar a devida atitude e em seguida marcar o reporte como resolvido ou ignorado.</p>
    </div>

    <h1 class="title">
        <i class="fas fa-users"></i>
        Suportes Ignorados
    </h1>

    <table>
        <tr>
            <th>
                Id
            </th>
            <th>
                Aberto por
            </th>
            <th>
                Dúvida
            </th>
            <th>
                Status
            </th>
            <th>
                Ações
            </th>
        </tr>
        <?php if(count($supports) > 0):?>
            <?php foreach($supports as $support): ?>
                <tr>
                    <td>
                        <?=$support['id'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$support['user_id'];?>"><?=$support['user_name'];?></a>
                    </td>
                    <td class="less">
                        <?=$support['title'];?>
                    </td>
                    <td>
                        <?=$support['status'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/suporte/<?=$support['id'];?>" class="btn seeReports">
                            <?php if($user['access'] < 3): ?>
                                <i class="fas fa-lock"></i>
                            <?php endif; ?>
                            Abrir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php if(count($supports) < 1):?>
        <h1 class="empty">
            Não tem nenhum suporte ignorado
        </h1>
    <?php endif; ?>

    <?php if($totalPages > 1): ?>
        <ul class="box-pagination">
            <?php for($q=1; $q<=$totalPages; $q++): ?>
                <a href="/Painel/suportes/ignorados?<?php 
                $currentUrl = $_GET;
                $currentUrl['pg'] = $q;
                echo http_build_query($currentUrl);
                ?>"><li class="<?=($q == $page) ? 'paginationSelected' : ''?>"> <?=$q?> </li></a>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
        
@endsection

<!--Scripts-->
@section('scripts')

@endsection