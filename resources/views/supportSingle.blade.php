@extends('layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - Suporte "<?=$supportInfo['title'];?>""
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/supportSingle.css" />
@endsection

<!--Content-->
@section('content')
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

@endsection