@extends('layouts.struct')

<!--Page title-->
@section('title')
EnglishVtp - quem <?=$infoProfile['user_name'];?> segue
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/relations.css" />
@endsection

<!--Content-->
@section('content')

    <h1 class="mainTitle">
        <?=($user['id'] == $infoProfile['id'])? 'Você' : $infoProfile['user_name'];?>
        esta seguindo <?= count($following) ?>
        <?= (count($following) > 1) ? 'pessoas' : 'pessoa' ?>
    </h1>

    <section class="screen">

        <?php if(count($following) > 0): ?>
            <?php foreach ($following as $followingSingle): ?>
                <div class="person">
                    <div class="info">
                        <img src="<?=$base_url;?>/media/avatars/<?=$followingSingle['photo'];?>" />
                        <div class="infoPerson">
                            <a href="<?=$base_url;?>/perfil/<?=$followingSingle['id'];?>"><?=$followingSingle['user_name'];?></a>
                            <b>Nivel: <?=$followingSingle['level'];?></b>
                        </div>
                    </div>
                    <div class="actions">
                        <a class="btnChat">
                            <i class="fas fa-comment-alt"></i>
                        </a>
                        <a href="<?=$base_url;?>/perfil/<?=$followingSingle['id'];?>" class="btn">
                            Ver perfil
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1 class="noPerson">
                <i class="far fa-frown-open"></i>
                <?=($user['id'] == $infoProfile['id'])? 'Você' : $infoProfile['user_name'];?>
                não esta seguindo ninguém.
            </h1>
        <?php endif; ?>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection