@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - suporte aberto "<?=$support['title'];?>"
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/admin/supportSingle.min.css" />
@endsection

<!--Content-->
@section('content')

    <?php if($support['status'] == 'pendente'): ?>
        <div class="bar">
            <a class="ignored" href="<?=$base_url;?>/Painel/mudarStatusSuporte/ignorado/<?=$support['id'];?>">Ignorado</i></a>
            <a class="resolved" href="<?=$base_url;?>/Painel/mudarStatusSuporte/resolvido/<?=$support['id'];?>">Resolvido</i></a>
        </div>
    <?php endif; ?>
    <?php if($support['status'] == 'resolvido'): ?>
        <div class="bar">
            <a class="pending" href="<?=$base_url;?>/Painel/mudarStatusSuporte/pendente/<?=$support['id'];?>">Pendente</i></a>
            <a class="ignored" href="<?=$base_url;?>/Painel/mudarStatusSuporte/ignorado/<?=$support['id'];?>">Ignorar</i></a>
        </div>
    <?php endif; ?>
    <?php if($support['status'] == 'ignorado'): ?>
        <div class="bar">
            <a class="pending" href="<?=$base_url;?>/Painel/mudarStatusSuporte/pendente/<?=$support['id'];?>">Pendente</i></a>
            <a class="resolved" href="<?=$base_url;?>/Painel/mudarStatusSuporte/resolvido/<?=$support['id'];?>">Resolvido</i></a>
        </div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
    <div class="flash success">
        <i class="fas fa-check-circle"></i>
        <?=$success;?>
    </div>
    <?php endif; ?>

    <?php if(!empty($error)): ?>
    <div class="flash error">
        <i class="fas fa-check-circle"></i>
        <?=$error;?>
    </div>
    <?php endif; ?>

    <h1 class="title"><?=$support['title'];?></h1>

    <section class="box-comment">
        <div class="commentSingle">
            <div class="box-info">
                <img src="<?=$base_url?>/media/avatars/<?=$support['photo'];?>" />
                <div class="infouser">
                    <p><?=$support['user_name'];?></p>
                    <span><?=date('d/m/Y H:i', $support['date']);?></span>
                </div>
            </div>
            <p>
                <?=str_replace('&#13;', '<br/>', $support['content']);?>
            </p>
        </div>

        <?php if(count($supportReplys) > 0): ?>
            <?php foreach($supportReplys as $supportReply): ?>
                <div class="commentSingle">
                    <div class="box-info">
                        <img src="<?=$base_url?>/media/avatars/<?=$supportReply['photo']?>" />
                        <div class="infouser">
                            <p><?=$supportReply['user_name']?></p>
                            <span><?=date('d/m/Y H:i',$supportReply['date']);?></span>
                        </div>
                    </div>
                    <p><?=str_replace('&#13;', '<br/>', $supportReply['comment']);?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($totalPages > 1): ?>
            <ul class="box-pagination">
                <?php for($q=1; $q <= $totalPages; $q++): ?>

                    <a href="<?=$base_url;?>/Painel/suporte/<?=$support['id'];?>?pg=<?=$q;?>">
                        <li class="<?=($q == $page) ? 'paginationSelected' : ''?>"><?php echo $q?></li>
                    </a>

                <?php endfor; ?>
            </ul>
        <?php endif; ?>

    </section>

    <section class="box-writeAReply">
        <h1>Responda:</h1>
        <form method="POST" action="<?=$base_url;?>/respondeSuporte/<?=$support['id'];?>">
            @csrf
            <textarea required name="reply" placeholder="Escreva um comentário"></textarea>
            <button>Enviar</button>
        </form>
    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection