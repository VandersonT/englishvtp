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
    <link rel="stylesheet" href="{{url('assets/css/initial.css')}}" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <noscript>Você precisa ativar o Javascript de seu navegador para visualizar o site corretamente.</noscript>

    <section class="imageBackground">

            <div class="box-menu">
                <a href="{{url('/')}}" class="logo"></a>

                <nav class="menuDesktop">
                    <ul>
                        <a href="{{url('/login')}}"><li>
                            <i class="fas fa-sign-in-alt"></i>
                            Entrar
                        </li></a>
                        <a href="{{url('/cadastrar')}}"><li>
                            <i class="fas fa-user-plus"></i>
                            Cadastrar
                        </li></a>
                    </ul>
                </nav>

                <div class="openMenuMobile">
                    <i class="fas fa-bars icon-menu-mobile"></i>
                </div>

                <div class="closeMenuMobile animate__animated animate__bounceInRight">
                    <i class="fas fa-window-close"></i>
                </div>

                <nav class="menuMobile animate__animated animate__bounceInLeft">
                    <ul>
                        <a href="{{url('/login')}}"><li>
                            <i class="fas fa-sign-in-alt"></i>
                            Entrar
                        </li></a>
                        <a href="{{url('cadastrar')}}"><li>
                            <i class="fas fa-user-plus"></i>
                            Cadastrar
                        </li></a>
                    </ul>
                </nav>
            </div>

            <div class="intro">
                <h1><?=$data->title;?></h1>
            
                <div class="introItens">
                    <p>
                        <i class="fas fa-circle"></i>
                        <?=$data->point1;?>
                    </p>
                    <p>
                        <i class="fas fa-circle"></i>
                        <?=$data->point2;?>
                    </p>
                    <p>
                        <i class="fas fa-circle"></i>
                        <?=$data->point3;?>
                    </p>
                    <p>
                        <i class="fas fa-circle"></i>
                        <?=$data->point4;?>
                    </p>
                </div>
            </div>

            <div class="btn-bellow">
                <a href="#?">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>

    </section>

    <section id="?" class="section1">
        <div class="section1-img"></div>
        <div class="section1-content">
            <h1><?=$data->title2;?></h1>
            <p>
                <?=$data->about;?>
            </p>
        </div>
    </section>

    <section class="section2">
        <h1 class="section2-title"><?=$data->title3;?></h1>

        <div class="box-whyEnglishVtp">
            <div class="whySingle">
                <h1>
                    <i class="fas fa-fire"></i>
                    <?=$data->subTitle1;?>
                </h1>
                <p>
                    <?=$data->content1;?>
                </p>
            </div>

            <div class="whySingle">
                <h1>
                    <i class="fas fa-disease"></i>
                    <?=$data->subTitle2;?>
                </h1>
                <p>
                    <?=$data->content2;?>
                </p>
            </div>

            <div class="whySingle">
                <h1>
                    <i class="fas fa-assistive-listening-systems"></i>
                    <?=$data->subTitle3;?>
                </h1>
                <p>
                    <?=$data->content3;?>
                </p>
            </div>

            <div class="whySingle">
                <h1>
                    <i class="fas fa-teeth-open"></i>
                    <?=$data->subTitle4;?>
                </h1>
                <p>
                    <?=$data->content4;?>
                </p>
            </div>

            <div class="whySingle">
                <h1>
                    <i class="fas fa-directions"></i>
                    <?=$data->subTitle5;?>
                </h1>
                <p>
                    <?=$data->content5;?>
                </p>
            </div>
        </div>

    </section>

    <section class="section3">
        <div class="section3-img"></div>
        
        <div class="section3-boxInfo">
            <h1 class="section3-title"><?=$data->title4;?></h1>
            <p><?=$data->about2;?></p>
        </div>
    </section>

    <section class="section4">

        <div class="info">
            <h1><?=$totalAccess?></h1>
            <p>Acessos</p>
        </div>

        <div class="info">
            <h1><?=$totalTexts;?></h1>
            <p>Textos+áudios disponiveis</p>
        </div>

        <div class="info">
            <h1><?=$totalStudiedTexts?></h1>
            <p>Textos estudados pelos usuários</p>
        </div>
    </section>

    <footer>
        englishvtp © 2021 - created by VandersonT
    </footer>

    <script src="{{url('assets/js/initial.js')}}"></script>
</body>
</html>