@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
    Painel - Novo texto
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/text.min.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.min.css" />
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
                <input name="audio" type="file" id="audio" required/>

                <label for="image" class="subTitle">
                    <i class="fas fa-images"></i>
                    Envie uma imagem:
                </label>
                <input name="image" type="file" id="image" required/>
            </div>

            <div  class="div2">
                <label for="image" class="subTitle">
                    <i class="fas fa-level-up-alt"></i>
                    Nivel do inglês:
                </label>
                <select name="englishLevel" required>
                    <option value="básico">Básico</option>
                    <option value="intermediário">Intermediário</option>
                    <option value="avançado">Avançado</option>
                    <option value="superavançado">Super-Avançado</option>
                </select>

                <label for="image" class="subTitle">
                    <i class="fas fa-calculator"></i>
                    Pontos que o texto vale:
                </label>
                <input min="0" type="number" id="points" name="points" required/>
                
                <a class="helpme"><i class="fas fa-question"></i>Ajuda escolher</a>

                <div class="help">
                    <h1><i class="fas fa-dragon"></i>Tabela de pontos</h1>
                    <p><b>Básico:</b> 0 - 999</p>
                    <p><b>Intermediario:</b> 1000 - 2999</p>
                    <p><b>Avançado:</b> 3000 - 9999</p>
                    <p><b>SuperAvançado:</b> 10000 - ∞</p>
                    <a class="btnClose">Fechar</a>
                </div>

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
                <input type="text" placeholder="Titulo em inglês" name="englishTitle" required/>
                <textarea name="englishContent" placeholder="Escreva o texto em inglês" required></textarea>
            </div>
            <div class="box2">
                <input type="text" placeholder="Titulo em português" name="portugueseTitle" required/>
                <textarea name="portugueseContent" placeholder="Escreva o texto em português" required></textarea>
            </div>
        </section>

        <button>Gerar Texto</button>
    </form>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
    <script src="<?=$base_url;?>/assets/js/admin/text.min.js"></script>
    <script src="<?=$base_url;?>/assets/js/admin/confirmToExit.min.js"></script>
@endsection