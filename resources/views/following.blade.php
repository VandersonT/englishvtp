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
        esta seguindo:
    </h1>

    <section class="screen">

        <?php if(count($followers) > 0): ?>
            <?php foreach ($followers as $follower): ?>
                <div class="person">
                    <div class="info">
                        <img src="<?=$base_url;?>/media/avatars/<?=$follower['photo'];?>" />
                        <div class="infoPerson">
                            <p><?=$follower['user_name'];?></p>
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
            <h1 class="noPerson">Não possui nenhum seguidor ainda</h1>
        <?php endif; ?>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection