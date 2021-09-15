@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
    Painel - Editar tela inicial
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/editInitialScreen.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($currentInformation): ?>
    <h1 class="mainTitle"><i class="far fa-bookmark"></i>Tela de Apresentação:</h1>

    <form method="POST">
        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 1</h1>
            <label for="mainTitle">Titulo principal:</label>
            <input maxlength="36" id="mainTitle" type="text" value="<?=$currentInformation['title']?>"/>
            <label for="point1">Ponto 1:</label>
            <input maxlength="36" id="point1" type="text" value="<?=$currentInformation['point1']?>"/>
            <label for="point2">Ponto 2:</label>
            <input maxlength="36" id="point2" type="text" value="<?=$currentInformation['point2']?>"/>
            <label for="point3">Ponto 3:</label>
            <input maxlength="36" id="point3" type="text" value="<?=$currentInformation['point3']?>"/>
            <label for="point4">Ponto 4:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['point4']?>"/>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 2</h1>
            <label for="mainTitle">Titulo:</label>
            <input maxlength="36" id="mainTitle" type="text" value="<?=$currentInformation['title2']?>"/>
            <label for="point1">Descrição:</label>
            <textarea><?=$currentInformation['about']?></textarea>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 3</h1>
            <label for="mainTitle">Titulo:</label>
            <input maxlength="36" id="mainTitle" type="text" value="<?=$currentInformation['title3']?>"/>
            <label for="point4">Subtitulo 1:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['subTitle1']?>"/>
            <label for="point1">Conteúdo 1:</label>
            <textarea><?=$currentInformation['content1']?></textarea>
            <br/>
            <label for="point4">Subtitulo 2:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['subTitle2']?>"/>
            <label for="point1">Conteúdo 2:</label>
            <textarea><?=$currentInformation['content2']?></textarea>
            <br/>
            <label for="point4">Subtitulo 3:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['subTitle3']?>"/>
            <label for="point1">Conteúdo 3:</label>
            <textarea><?=$currentInformation['content3']?></textarea>
            <br/>
            <label for="point4">Subtitulo 4:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['subTitle4']?>"/>
            <label for="point1">Conteúdo 4:</label>
            <textarea><?=$currentInformation['content4']?></textarea>
            <br/>
            <label for="point4">Subtitulo 5:</label>
            <input maxlength="36" id="point4" type="text" value="<?=$currentInformation['subTitle5']?>"/>
            <label for="point1">Conteúdo 5:</label>
            <textarea><?=$currentInformation['content5']?></textarea>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 4</h1>
            <label for="mainTitle">Titulo:</label>
            <input maxlength="36" id="mainTitle" type="text" value="<?=$currentInformation['title4']?>"/>
            <label for="point1">Sobre 2:</label>
            <textarea><?=$currentInformation['about2']?></textarea>
        </section>

        <button>Concluir</button>
    </form>
    <?php else: ?>
        <div class="warn">
            <h1>
                <i class="fas fa-exclamation-triangle"></i>
                Ocorreu um erro gravissimo ao tentar pegar os dados do banco de dados
            </h1>
            <p class="possibleCauses"><b>Alerta:</b> Se ocorreu esse erro aqui, confira urgentemente se não esta ocorrendo o mesmo no sistema principal.</p>
            <a href="<?=$base_url;?>" target="_blank">Ir para o sistema agora</a>        
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')

@endsection