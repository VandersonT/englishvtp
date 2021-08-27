<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width,height=device-height" />
    <meta name="description" content="Aprenda inglês com um dos melhores métodos de estudos, o texto com áudio, com um sistema especializado para te ajudar a chegar mais longe." />
    <meta name="keyword" content="ingles,aprenderIngles,texto+audio,textosingles,textosemingles,textocomaudioingles,audiosemingles" />
    <meta name="author" content="VandersonT"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" type="image-x/png" href="{{url('icon.png')}}">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/struct.css')}}" />
    @yield('links')

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <noscript>Você precisa ativar o Javascript de seu navegador para visualizar o site corretamente.</noscript>

    <header class="box-menu">
        <a href="<?=$base_url;?>/" class="logo"></a>

        <div class="contentHeader">

            <nav class="menuDesktop">
                <ul>
                    <a class="<?= ($selected == 'home') ? 'selected' : '';?>" href="<?=$base_url?>/"><li>
                        Inicio
                    </li></a>

                    <a class="<?= ($selected == 'mytexts') ? 'selected' : '';?>" href="<?=$base_url;?>/meustextos"><li>
                        Meus textos
                    </li></a>

                    <a class="<?= ($selected == 'chat') ? 'selected' : '';?>" href="#"><li>
                        Chat
                        <span class="chatNotification">
                            9
                        </span>
                    </li></a>

                    <a href="<?=$base_url?>/perfil/<?=$user['id']?>" class="<?= ($selected == 'profile') ? 'selected' : '';?>"><li>
                        Seu perfil
                    </li></a>

                    <a onclick="return confirm('Você tem certeza que quer sair?')" href="{{url('sair')}}" class="close" ><li>
                        Sair
                    </li></a>
                    
                </ul>
            </nav>

            <a class="bell" href="#"><li>
                <i class="fas fa-bell"></i>
                <?php if(count($notifications) != 0): ?>
                    <span class="bellNotification">
                        <?=count($notifications)?>
                    </span>
                <?php endif; ?>
            </li></a>

            <div class="notification">
                <?php if(!empty($notifications) && count($notifications) != 0): ?>
                    <?php foreach ($notifications as $notification):?>
                        <a href="<?=$notification['whereOcurred'];?>" class="notificationSingle" dataId="<?= $notification['id'];?>">
                            <img src="<?=$base_url;?>/media/avatars/<?=$notification['photo'];?>" />
                            <div class="notificationInfo">
                                <p><?=$notification['message'];?></p>
                                <p><?= date('d/m/Y H:i', $notification['date']);?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>  
                    <h1 class="noNotification">
                        <i class="fas fa-dot-circle"></i>
                        Você não tem nenhuma notificação nova.
                    </h1>
                <?php endif; ?>

            </div>

            <div class="btnMobile">
                <i class="fas fa-bars"></i>
            </div>

            <nav class="menuMobile">
                <ul>
                    <a href="<?=$base_url?>/"><li class="selectedMobile">
                        Inicio
                    </li></a>

                    <a href="#"><li>
                        Meus textos
                    </li></a>

                    <a href="#"><li>
                        Chat
                        <span class="chatNotification">
                            9
                        </span>
                    </li></a>

                    <a href="<?=$base_url?>/perfil/<?=$user['id']?>"><li>
                        Perfil
                    </li></a>

                    <a onclick="return confirm('Você tem certeza que quer sair?')" href="{{url('sair')}}"><li>
                        Sair
                    </li></a>
                </ul>
            </nav>

        </div>

    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
    <script>
        let theme = "<?=$user['theme'];?>";
        let base_url = '<?=$base_url;?>';
    </script>
    <script src="{{url('assets/js/darkMode.js')}}"></script>
    <script src="{{url('assets/js/struct.js')}}"></script>
</body>
</html>