@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - perfil de <?=$infoProfile['user_name'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/profile.css" />
@endsection

<!--Content-->
@section('content')
    <section class="view">
        <h1 class="title">
            <i class="fas fa-id-card-alt"></i>
            <?=($infoProfile['user_name'] == $user['name']) ? 'Seu perfil - '.$infoProfile['user_name'] : 'Perfil de '.$infoProfile['user_name'];?>
        </h1>
        <div class="box-info">
            <img src="<?=$base_url;?>/media/avatars/no-picture2.png" />
            
            <h1 class="title">Informações Básicas</h1>

            <div class="info">
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-id-card"></i>
                        Id:
                    </h1>
                    <p><?=$infoProfile['id'];?></p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-file-signature"></i>
                        Nome:
                    </h1>
                    <p><?=$infoProfile['user_name'];?></p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-envelope"></i>
                        Email:
                    </h1>
                    <p><?=$infoProfile['email'];?></p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-briefcase"></i>
                        Cargo:
                    </h1>
                    <p>
                        <?=($infoProfile['access'] == 1) ? 'Usuário' : '' ;?>
                        <?=($infoProfile['access'] == 2) ? 'Ajudante' : '' ;?>
                        <?=($infoProfile['access'] == 3) ? 'Administrador' : '' ;?>
                        <?=($infoProfile['access'] == 4) ? 'Moderador' : '' ;?>
                        <?=($infoProfile['access'] == 5) ? 'Dono' : '' ;?>
                    </p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-level-up-alt"></i>
                        Nivel:
                    </h1>
                    <p>A1</p>
                </div>
                <a  target="_blank" href="<?=$base_url;?>/perfil/<?=$infoProfile['id'];?>" class="button">
                    Ver perfil no sistema
                </a>
            </div>
        </div>
    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection