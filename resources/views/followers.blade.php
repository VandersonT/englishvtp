@extends('layouts.struct')

<!--Page title-->
@section('title')
EnglishVtp - quem segue <?=$infoProfile['user_name'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/relations.css" />
@endsection

<!--Content-->
@section('content')
    <h1 class="mainTitle">Seguidores</h1>
    <!--
        Esta tela servirá tanto para ver seus seguidores
        quanto quem você esta seguindo.
        Esta tela também será usada para ver os seguidores 
        de outras pessoas e quem elas estao seguindo
        
        Frases do h1/mainTitle
            *Seus seguidores
            *Quem te segue
            *Seguidores de X
            *Pessoas que X esta seguindo
    -->

    <section class="screen">

        <!--
        <div class="person">
            <div class="info">
                <img src="media/avatars/no-picture2.png" />
                <div class="infoPerson">
                    <a href="">Barbara top</a>
                    <b>Nivel: Basico</b>
                </div>
            </div>
            <div class="actions">
                <a class="btnChat">
                    <i class="fas fa-comment-alt"></i>
                </a>
                <a class="btn">Seguir</a>
            </div>
        </div>

        <div class="person">
            <div class="info">
                <img src="media/avatars/no-picture2.png" />
                <div class="infoPerson">
                    <a href="">Izabela</a>
                    <b>Nivel: Basico</b>
                </div>
            </div>
            <div class="actions">
                <a class="btnChat">
                    <i class="fas fa-comment-alt"></i>
                </a>
                <a class="btn">Seguir</a>
            </div>
        </div>

        <div class="person">
            <div class="info">
                <img src="media/avatars/no-picture2.png" />
                <div class="infoPerson">
                    <a href="">Pedro Nascimento</a>
                    <b>Nivel: Basico</b>
                </div>
            </div>
            <div class="actions">
                <a class="btnChat">
                    <i class="fas fa-comment-alt"></i>
                </a>
                <a class="btn">Seguir</a>
            </div>
        </div>

        <div class="person">
            <div class="info">
                <img src="media/avatars/no-picture2.png" />
                <div class="infoPerson">
                    <a href="">Amanda Silva</a>
                    <b>Nivel: Basico</b>
                </div>
            </div>
            <div class="actions">
                <a class="btnChat">
                    <i class="fas fa-comment-alt"></i>
                </a>
                <a class="btn">Seguir</a>
            </div>
        </div>
        -->

        <h1 class="noPerson">Não possui nenhum seguidor ainda</h1>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection