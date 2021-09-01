<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>EnglishVtp - Painel login</title>
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
    <link rel="stylesheet" href="{{url('assets/css/admin/loginAdmin.css')}}" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="screen">
        <form method="POST" action="">
            <h1 class="title">
                <i class="fas fa-user-cog"></i>
                Login Admin
            </h1>
            <input type="email" name="email" placeholder="E-mail" />
            <input type="text" name="password" placeholder="Senha"/>
            <label>
                <input type="checkbox" name="keepConnected"/>
                <p>Manter conectado</p>
            </label>
            <button>Entrar</button>
        </form>
    </section>
</body>
</html>