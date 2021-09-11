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
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/ban.css" />

    <script src="https://kit.fontawesome.com/90bf9437da.js" crossorigin="anonymous"></script>
</head>
<body>
    <noscript>Você precisa ativar o Javascript de seu navegador para visualizar o site corretamente.</noscript>

    <div class="background"></div>
    <div class="screen">
        <div class="boxInfo">
            <div class="header">
                <h1><i class="fas fa-ban"></i>Conta Banida</h1>
            </div>
            <div class="body">
                <p class="title">Motivo:</p>
                <p><?=$infoBan['reason']?></p>
                <p class="title">Responsavel:</p>
                <p><?=$infoBan['user_name']?></p>
                <p class="title">Fim do ban:</p>
                <p>
                    <?=($infoBan['time'] == 'eterno') ? 'Nunca' : date('d/m/Y H:i', $infoBan['time']) ;?>
                </p>
            </div>
            <div class="boxBtns">
                <a class="close" href="<?=$base_url;?>/finalizaSessao">Sair</a>
            </div>
        </div>
    </div>

</body>
</html>