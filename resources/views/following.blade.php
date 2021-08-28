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

    <?php 
        if($infoProfile['id'] == $user['id']){
            $selected = 'profile';
        }else{
            $selected = 'none';
        }
    ?>

    <div class="menu">
        <a href="#" class="returnBtn" onClick="window.history.back();"><i class="fas fa-undo-alt"></i></a>
        <div class="aboutProfile">
            <img src="<?= $base_url;?>/media/avatars/<?= $infoProfile['photo'];?>" />
            <a href="<?=$base_url;?>/perfil/<?= $infoProfile['id'];?>"><?= $infoProfile['user_name'];?></a>
        </div>
    </div>

    <h1 class="mainTitle">
        Seguindo (<?= count($following); ?>)
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
    <?php if($totalPages > 1): ?>
        <ul class="box-pagination">
            <?php for($q=1; $q <= $totalPages; $q++): ?>

                <a href="<?=$base_url;?>/perfil/seguindo/<?=$infoProfile['id'];?>?pg=<?=$q;?>">
                    <li class="<?=($q == $page) ? 'paginationSelected' : ''?>"><?php echo $q?></li>
                </a>

            <?php endfor; ?>
        </ul>
    <?php endif; ?>
@endsection

<!--Scripts-->
@section('scripts')

@endsection