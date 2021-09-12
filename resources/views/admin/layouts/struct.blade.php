<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width,height=device-height" />
    <meta name="description" content="Painel administrativo do sistema 'EnglishVtp'." />
    <title>@yield('title')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" type="image-x/png" href="{{url('iconAdmin.ico')}}">
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/admin/struct.css" />
    @yield('links')

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
                <a class="<?= ($selected == 'dashboard') ? 'selected' : '';?>" href="<?=$base_url;?>/Painel/">
                    <i class="fas fa-eye"></i>
                    <p>Dashboard</p>
                </a>
                <a class="<?= ($selected == 'pages') ? 'selected' : '';?>" href="<?=$base_url;?>/Painel/paginas">
                    <i class="fas fa-file-alt"></i>
                    <p>Páginas</p>
                </a>

                <div class="btnBox">
                    <i class="fas fa-user"></i>
                    <p>Usuários</p>
                    <i class="fas fa-caret-left arrow"></i>
                </div>
                <div class="boxBtns">
                    <a href="<?=$base_url;?>/Painel/usuarios" class="<?= ($selected == 'users') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Ver usuários
                    </a>
                    <a href="<?=$base_url;?>/Painel/staffs" class="<?= ($selected == 'staffs') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Membros da staff
                    </a>
                    <a href="<?=$base_url;?>/Painel/banidos" class="<?= ($selected == 'bans') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Banidos
                    </a>
                    <a href="<?=$base_url;?>/Painel/exilio" class="<?= ($selected == 'exile') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Exilados
                    </a>
                </div>

                <div class="btnBox">
                    <i class="fas fa-align-left"></i>
                    <p>Textos</p>
                    <i class="fas fa-caret-left arrow"></i>
                </div>
                <div class="boxBtns">
                    <a href="<?=$base_url;?>/Painel/novoTexto" class="<?= ($selected == 'newText') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Novo Texto
                    </a>
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Editar Textos
                    </a>
                </div>

                <div class="btnBox">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Reportes</p>
                    <i class="fas fa-caret-left arrow"></i>
                </div>
                <div class="boxBtns">
                    <a href="<?=$base_url;?>/Painel/reportes/pendentes" class="<?= ($selected == 'reportsP') ? 'selected' : '';?>">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Pendentes
                    </a>
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Resolvidos
                    </a>
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Ignorados
                    </a>
                </div>

                <div class="btnBox <?= ($selected == 'support') ? 'selected' : '';?>">
                    <i class="fas fa-ticket-alt"></i>
                    <p>Suporte</p>
                    <i class="fas fa-caret-left arrow"></i>
                </div>
                <div class="boxBtns">
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Pendentes
                    </a>
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Resolvidos
                    </a>
                    <a href="">
                        <i class="fas fa-circle iconSubMenu"></i>
                        Ignorados
                    </a>
                </div>

                <a class="<?= ($selected == 'profile') ? 'selected' : '';?>" href="<?=$base_url;?>/Painel/perfil/<?=$user['id'];?>">
                    <i class="fas fa-male"></i>
                    <p>Seu Perfil</p>
                </a>

                <a target="_blank" class="<?= ($selected == 'goToSystem') ? 'selected' : '';?>" href="<?=$base_url;?>/">
                    <i class="fas fa-sitemap"></i>
                    <p>Ir para o sistema</p>
                </a>

                <a class="close" href="<?=$base_url;?>/Painel/sair" onClick="return confirm('Você quer realmente sair?');">
                    <i class="fas fa-power-off"></i>
                    <p>Sair</p>
                </a>
            </div>
        </section>
        <section class="box-content">
            @yield('content')
        </section>
    </div>

    @yield('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/struct.js"></script>
    <script>let base_url = '<?=$base_url;?>';</script>
</body>
</html>