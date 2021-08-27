@extends('layouts.struct')

<!--Page title-->
@section('title')
EnglishVtp - quem segue <?=$infoProfile['user_name'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/relations.css" />
@endsection

<!--Content-->
@section('content')

    <h1 class="mainTitle">
        <?= count($followers) ?>
        <?= (count($followers) > 1) ? 'pessoas estão seguindo' : 'pessoa segue' ?>
        <?=($user['id'] == $infoProfile['id'])? 'você' : $infoProfile['user_name'];?>
    </h1>

    <section class="screen">

        <?php if(count($followers) > 0): ?>
            <?php foreach ($followers as $follower): ?>
                <div class="person">
                    <div class="info">
                        <img src="<?=$base_url;?>/media/avatars/<?=$follower['photo'];?>" />
                        <div class="infoPerson">
                            <a href="<?=$base_url;?>/perfil/<?=$follower['id'];?>"><?=$follower['user_name'];?></a>
                            <b>Nivel: <?=$follower['level'];?></b>
                        </div>
                    </div>
                    <div class="actions">
                        <a class="btnChat">
                            <i class="fas fa-comment-alt"></i>
                        </a>
                        <a href="<?=$base_url;?>/perfil/<?=$follower['id'];?>" class="btn">
                            Ver perfil
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h1 class="noPerson">
                <i class="far fa-frown-open"></i>
                <?=($user['id'] == $infoProfile['id'])? 'Você' : $infoProfile['user_name'];?>
                não tem nenhum seguidor ainda.
            </h1>
        <?php endif; ?>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection