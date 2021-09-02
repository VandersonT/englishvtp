<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width,height=device-height" />
    <meta name="description" content="Painel administrativo do sistema 'EnglishVtp'." />
    <title>Sem nome</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" type="image-x/png" href="{{url('iconAdmin.ico')}}">
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/admin/struct.css" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="screen">
        <div class="btnMobile"><i class="fas fa-caret-square-right"></i></div>
        <section class="box-menu">
            <div class="logo">
                <h1>
                    <i class="fas fa-users-cog"></i>
                    Painel EnglishVtp
                </h1>
            </div>
            <div class="infoUser">
                <img src="<?=$base_url;?>/media/avatars/<?=$user['photo'];?>" />
                <div>
                    <p><?=$user['name'];?></p>
                    <span>
                        <?php if($user['access'] == 2): ?>
                            <i class="fas fa-circle helper"></i>
                            Ajudante
                        <?php elseif($user['access'] == 3): ?>
                            <i class="fas fa-circle moderator"></i>
                            Moderador
                        <?php elseif($user['access'] == 4): ?>
                            <i class="fas fa-circle administrator"></i>
                            Administrador
                        <?php elseif($user['access'] == 5): ?>
                            <i class="fas fa-circle owner"></i>
                            Dono
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <div class="menu">
                <a class="selected" href="#">
                    <i class="fas fa-eye"></i>
                    <p>Dashboard</p>
                </a>
                <a href="#">
                    <i class="fas fa-file-alt"></i>
                    <p>Páginas</p>
                </a>
                <a href="#">
                    <i class="fas fa-user"></i>
                    <p>Usuários</p>
                </a>
                <a href="#">
                    <i class="fas fa-align-left"></i>
                    <p>Textos</p>
                </a>
                <a href="#">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Reportes</p>
                </a>
                <a href="#">
                    <i class="fas fa-ticket-alt"></i>
                    <p>Suporte</p>
                </a>

                <a href="#">
                    <i class="fas fa-sitemap"></i>
                    <p>Ir para o sistema</p>
                </a>

                <a class="close" href="#">
                    <i class="fas fa-door-open"></i>
                    <p>Sair</p>
                </a>
            </div>
        </section>
        <section class="box-content">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nibh lorem, tempor et velit nec, ullamcorper commodo enim. Etiam nibh leo, fermentum sed hendrerit quis, porttitor at justo. Integer tempus, purus at rhoncus lacinia, risus purus feugiat neque, et ultricies lectus mauris ut elit. Curabitur at pretium quam. Vestibulum tristique nisl at sodales tristique. Aenean eleifend eleifend sapien, sit amet mattis enim tincidunt sed. Cras at turpis et sapien lobortis sodales vitae ac mi. Ut sit amet velit nibh. Praesent porttitor molestie convallis. In sit amet dapibus nibh, non mattis leo. Nam pharetra, mi fermentum ultricies lobortis, turpis turpis varius justo, sed sodales orci risus quis massa. Mauris neque neque, aliquam sit amet lorem eu, malesuada vestibulum est.
        </section>
    </div>

    <script src="<?=$base_url;?>/assets/js/admin/struct.js"></script>
</body>
</html>