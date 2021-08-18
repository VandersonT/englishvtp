<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Englishvtp - login</title>
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
    <link rel="shortcut icon" type="image-x/png" href="icon.png">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/login.css')}}" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <noscript>Você precisa ativar o Javascript de seu navegador para visualizar o site corretamente.</noscript>

    <header class="box-menuDesktop">
        
        <a class="return" href="{{url('/inicio')}}">
            <i class="fas fa-undo-alt"></i>
        </a>

        <div class="box-logo">
            <div class="logo"></div>
        </div>

    </header>

    <section class="contentLogin">
        <h1>
            Bem-vindo de volta 
            <i class="far fa-smile-beam"></i>
        </h1>

        <form method="POST">
            <input type="email" placeholder="E-mail"/>
            <input type="password" placeholder="Senha" />

            <div class="keepConnected">
                <input id="keepConnected" type="checkbox" />
                <label for="keepConnected">Manter conectado</label>
            </div>

            <button>Entrar</button>
            <a class="forgetPass" href="{{url('/')}}">Esqueci minha senha</a>
        </form>

        <div class="box-alternateLogin">
            <a href="{{url('/')}}" class="alternateLogin">
                <img src="{{url('assets/images/google.ico')}}" />
                <p>Entrar com google</p>
            </a>

            <a href="{{url('/')}}" class="alternateLogin">
                <img src="{{url('assets/images/facebook.png')}}" />
                <p>Entrar com facebook</p>
            </a>
        </div>

    </section>

</body>
</html>