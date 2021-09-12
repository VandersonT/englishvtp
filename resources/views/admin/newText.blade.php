@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - novo texto
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/newText.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.css" />
@endsection

<!--Content-->
@section('content')

    <?php if($success): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Texto criado com sucesso</h1>
            <p><?=$success;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($error): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="error">Envio negado</h1>
            <p><?=$error;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <h1 class="title">
        <i class="far fa-file-alt"></i>
        Escreva um novo texto
    </h1>

    <form class="formText" method="POST" action="<?=$base_url;?>/Painel/enviaNovoTexto" enctype="multipart/form-data">
        @csrf
        <section class="firstSection">
            <div class="div1">
                <label for="audio" class="subTitle">
                    <i class="fas fa-play-circle"></i>
                    Envie o aúdio:
                </label>
                <input name="audio" type="file" id="audio"/>

                <label for="image" class="subTitle">
                    <i class="fas fa-images"></i>
                    Envie uma imagem:
                </label>
                <input name="image" type="file" id="image"/>
            </div>

            <div  class="div2">
                <label for="image" class="subTitle">
                    <i class="fas fa-level-up-alt"></i>
                    Nivel do inglês:
                </label>
                <select name="englishLevel">
                    <option value="básico">Básico</option>
                    <option value="intermediário">Intermediário</option>
                    <option value="avançado">Avançado</option>
                    <option value="superavançado">Super-Avançado</option>
                </select>

                <label for="image" class="subTitle">
                    <i class="fas fa-calculator"></i>
                    Pontos que o texto vale:
                </label>
                <input min="0" type="number" id="points" name="points"/>

                <label for="image" class="subTitle">
                    <i class="fas fa-globe-americas"></i>
                    Escolha o tipo de inglês:
                </label>
                <div class="boxRadios">
                    <input type="radio" name="englishType" value="americano"/>
                    <p>Americano</p>
                    <input type="radio" name="englishType" value="britanico"/>
                    <p>Britânico</p>
                </div>
            </div>
        </section>

        <section class="secondSection">
            <div class="box1">
                <input type="text" placeholder="Titulo em inglês" name="englishTitle"/>
                <textarea name="englishContent" placeholder="Escreva o texto em inglês"></textarea>
            </div>
            <div class="box2">
                <input type="text" placeholder="Titulo em português" name="portugueseTitle"/>
                <textarea name="portugueseContent" placeholder="Escreva o texto em português"></textarea>
            </div>
        </section>

        <button>Gerar Texto</button>
    </form>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.js"></script>
@endsection