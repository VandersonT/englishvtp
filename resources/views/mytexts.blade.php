@extends('layouts.struct')

<!--Page title-->
@section('title', 'EnglishVtp - meus textos')


<!--Links-->
@section('links')
    <link rel="stylesheet" href="assets/css/myTexts.css" />
@endsection

<!--Content-->
@section('content')
        
    <h1 class="title">Textos Salvos</h1>
    <section class="savedTexts">
        
        <div class="showcase">
            
            <div class="textSavedSingle">
                <img src="media/textCover/aguia.jpg" />
                <h3>Aguia</h3>
                <p>Nivel: Intermediario</p>

                <div class="btnsGroup">
                    <a class="openText" href="">Abrir</a>
                    <a class="deleteText" href="">Apagar</a>
                </div>
            </div>
        
        <!--
        <p class="noText">Você ainda não salvou nenhum texto.</p>
        -->
        </div>

    </section>

    <h1 class="title">Textos estudados</h1>

    <section class="textsStudied">

        
        <div class="textSavedSingle">
            <img src="media/textCover/gow.jpg" />
            <h3>Kratos - A saga do Olympus</h3>
            <p>Nivel: Avançado</p>

            <div class="btnsGroup">
                <a class="openText" href="">Abrir</a>
                <a class="deleteText" href="">Apagar</a>
            </div>
        </div>

        <div class="textSavedSingle">
            <img src="media/textCover/aguia.jpg" />
            <h3>Aguia</h3>
            <p>Nivel: Intermediario</p>

            <div class="btnsGroup">
                <a class="openText" href="">Abrir</a>
                <a class="deleteText" href="">Apagar</a>
            </div>
        </div>
        
        <!--
        <p class="noText">Você ainda não estudou nenhum texto.</p>
        -->

    </section>

@endsection

<!--Scripts-->
@section('scripts')

@endsection