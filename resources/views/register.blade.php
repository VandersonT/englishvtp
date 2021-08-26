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
    <link rel="shortcut icon" type="image-x/png" href="{{url('icon.png')}}">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/register.css')}}" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <noscript>Você precisa ativar o Javascript de seu navegador para visualizar o site corretamente.</noscript>

    <header class="box-menuDesktop">
        
        <a href="{{url('/inicio')}}" class="return" href="">
            <i class="fas fa-undo-alt"></i>
        </a>

        <div class="box-logo">
            <div class="logo"></div>
        </div>

    </header>

    <section class="contentLogin">
        <h1>
            Cadastre-se, aqui TUDO é 100% gratuito
            <i class="far fa-smile-beam"></i>
        </h1>

        <form method="POST" action="{{url('cadastrar')}}">

            <?php if($flash): ?>
                <div class="error animate__animated animate__flash">
                    <i class="fas fa-times"></i>
                    <?= $flash;?>
                </div>
            <?php endif; ?>

            @csrf
            <input maxlength="100" name="name" type="text" placeholder="Nome"/>
            <input maxlength="100" name="email" type="email" placeholder="E-mail"/>
            <input name="password" id="pass" type="password" placeholder="Senha" />
            <input name="confirmPassword" id="confirmPass" type="password" placeholder="Confirme a senha" />

            <div class="showPassword">
                <input id="showPassword" type="checkbox" />
                <label for="showPassword">Mostrar senha</label>
            </div>

            <button>Cadastrar</button>
            <a href="{{url('/login')}}" class="alreadyHaveAnAccount" href="#">Já tenho uma conta</a>
        </form>

    </section>


    <script src="{{url('assets/js/register.js')}}"></script>
</body>
</html>