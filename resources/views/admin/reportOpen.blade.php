@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - reporte contra <?=$report['reported_name'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/reportSingle.min.css" />
@endsection

<!--Content-->
@section('content')
    <?php if($report['status'] == 'pendente'){$selected = 'reportsP';}?>
    <?php if($report['status'] == 'resolvido'){$selected = 'reportsR';}?>
    <?php if($report['status'] == 'ignorado'){$selected = 'reportsI';}?>

    <div class="view">
        <div class="box">
            <img src="<?=$base_url;?>/media/avatars/<?=$report['reported_photo'];?>" />
            
            <h1>
                <i class="fas fa-signature"></i>
                Reportado: <?=$report['reported_name'];?>
                [<?=$report['reported_id'];?>]
            </h1>

            <p class="warn">
                <?php if($report['status'] == 'pendente'):?>
                    <i class="fas fa-exclamation"></i>
                    Este reporte ainda esta pendente, mas você pode mudar isso.
                <?php endif; ?>
                <?php if($report['status'] == 'resolvido'):?>
                    <i class="fas fa-exclamation"></i>
                    Este reporte já foi resolvido, mas você pode mudar isso.
                <?php endif; ?>
                <?php if($report['status'] == 'ignorado'):?>
                    <i class="fas fa-exclamation"></i>
                    Este reporte foi ignorado, mas você pode mudar isso.
                <?php endif; ?>
            </p>

            <b class="subTitle">Comentário reportado:</b>
            <div class="comment_reported">
                <p><?=$report['comment'];?></p>
                <p>feito: <?=date('d/m/Y',$report['last_update']);?></p>
            </div>

            <div class="box-btn">
                <?php if($report['status'] == 'pendente'):?>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/ignorado/<?=$report['id'];?>" class="ignore">Ignorar</a>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/resolvido/<?=$report['id'];?>" class="resolve">Resolvido</a>
                <?php endif; ?>
                <?php if($report['status'] == 'resolvido'):?>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/ignorado/<?=$report['id'];?>" class="ignore">Ignorar</a>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/pendente/<?=$report['id'];?>" class="pending">Pendente</a>
                <?php endif; ?>
                <?php if($report['status'] == 'ignorado'):?>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/pendente/<?=$report['id'];?>" class="pending">Pendente</a>
                    <a href="<?=$base_url;?>/Painel/mudarStatusReporte/resolvido/<?=$report['id'];?>" class="resolve">Resolvido</a>
                <?php endif; ?>
            </div>

        </div>
    </div>

@endsection

<!--Scripts-->
@section('scripts')

@endsection