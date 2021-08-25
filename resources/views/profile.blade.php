@extends('layouts.struct')

<!--Page title-->
@section('title')
Perfil - <?=$infoProfile['user_name'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="{{url('assets/css/profile.css')}}" />
@endsection

<!--Content-->
@section('content')
    
    <section class="boxProfile">
        <div class="photoProfile">
            <img src="<?= $base_url;?>/media/avatars/<?= $infoProfile['photo'];?>" />
        </div>
        <div class="boxInfoProfile">
            <div class="infoProfile">
                <h3>Nome:</h3> 
                <p><?= $infoProfile['user_name']?></p>
                
                <?php if($infoProfile['id'] == $user['id']): ?>
                    <a href="" class="btn btnConfig" href="#">
                        <i class="fas fa-tools"></i>
                        Editar Perfil
                    </a>
                <?php else:?>
                    <a href="<?=$base_url;?>/follow/<?=$infoProfile['id'];?>" class="btn followColor" href="#">
                        <?= ($userFollowsThisPerson) ? 'Seguindo' : 'Seguir'?>
                    </a>
                    <a href="" class="btn chatColor" href="#">Chat</a>
                    <a href="#" onClick="return confirm('Você quer realmente bloquear este usuário?');" class="btn blockColor" href="#">Bloquear</a>
                <?php endif;?>

            </div>
            <div class="infoProfile2">
                <div class="info2Single">
                    <p>Comentarios</p>
                    <p><?=$userComments;?></p>
                </div>
                <div class="info2Single">
                    <p>Seguindo</p>
                    <p><?=$following;?></p>
                </div>
                <div class="info2Single">
                    <p>Seguidores</p>
                    <p><?=$follower;?></p>
                </div>
            </div>
        </div>
    </section>
    <div class="box1">
        <p>Troféus conqusitados</p>
    </div>
    <section class="boxTrophies">
        <?php if(count($trophies) > 0): ?>
            <?php foreach ($trophies as $trophie):?>
                <div class="ThophieSingle">
                    <img title="<?=$trophie['trophie_description'];?>" src="<?=$base_url;?>/assets/images/trophies/<?=$trophie['trophie_icon'];?>" />
                    <h4><?=$trophie['trophie_name'];?></h4>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
                <p class="empty1">
                    <i class="fas fa-trophy"></i>
                    <?=($user['id'] == $infoProfile['id'])? 'Você' : 'Esse usuário'?> 
                    não possui nenhum troféu ainda.
                </p>
        <?php endif; ?>

    </section>
    <div class="box1">
        <p>Entrosamento</p>
    </div>
    <section class="boxActions">
       
        <?php if(count($interactions) > 0): ?>
            <?php foreach ($interactions as $interaction):?>
                <a href="<?=$interaction['whereOccurred']?>">
                    <div class="box2">
                        <img src="<?=$base_url;?>/media/avatars/<?=$infoProfile['photo'];?>" />
                        <div class="box2Info">
                            <h4>
                                <?=$interaction['message']?>
                            </h4>
                            <p>
                                <?=$interaction['userWords']?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach;?>
        <?php else: ?>
            <h1 class="empty2">
                <i class="fas fa-users"></i>
                <?=($user['id'] == $infoProfile['id'])? 'Você' : 'Esse usuário'?> 
                não realizou nenhuma interação ainda.
            </h1>
        <?php endif; ?>

    </section>

@endsection

<!--Scripts-->
@section('scripts')

@endsection