@extends('layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - Suporte "<?=$supportInfo['title'];?>""
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/flash.min.css" />
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/supportSingle.min.css" />
@endsection

<!--Content-->
@section('content')

    <?php if($exiled): ?>
    <div class="backgroundDark">
        <div class="flash2">
            <h1 class="error">Você esta exilado</h1>
            <p><?=$exiled;?></p>
            <button class="close2 btn">Fechar</button>
        </div>
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

    <h1 class="title"><?=$supportInfo['title'];?></h1>

    <section class="box-comment">
        <div class="commentSingle">
            <div class="box-info">
                <img src="<?=$base_url?>/media/avatars/<?=$user['photo'];?>" />
                <div class="infouser">
                    <p><?=$user['name'];?></p>
                    <span><?=date('d/m/Y H:i', $supportInfo['date']);?></span>
                </div>
            </div>
            <p>
                <?=str_replace('&#13;', '<br/>', $supportInfo['content']);?>
            </p>
        </div>

        <?php if(count($replys) > 0): ?>
            <?php foreach($replys as $reply): ?>
                <div class="commentSingle">
                    <div class="box-info">
                        <img src="<?=$base_url?>/media/avatars/<?=$reply['photo']?>" />
                        <div class="infouser">
                            <p><?=$reply['user_name']?></p>
                            <span><?=date('d/m/Y H:i',$reply['date']);?></span>
                        </div>
                    </div>
                    <p><?=str_replace('&#13;', '<br/>', $reply['comment']);?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($totalPages > 1): ?>
            <ul class="box-pagination">
                <?php for($q=1; $q <= $totalPages; $q++): ?>

                    <a href="<?=$base_url;?>/suporte/<?=$supportInfo['id'];?>?pg=<?=$q;?>">
                        <li class="<?=($q == $page) ? 'paginationSelected' : ''?>"><?php echo $q?></li>
                    </a>

                <?php endfor; ?>
            </ul>
        <?php endif; ?>

    </section>

    <section class="box-writeAReply">
        <h1>Responda</h1>
        <form method="POST" action="<?=$base_url;?>/respondeSuporte/<?=$supportInfo['id'];?>">
            @csrf
            <textarea required name="reply" placeholder="Escreva um comentário"></textarea>
            <button>Enviar</button>
        </form>
    </section>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
@endsection