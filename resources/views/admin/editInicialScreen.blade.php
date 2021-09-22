@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
    Painel - Editar tela inicial
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/editInitialScreen.min.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.min.css" />
@endsection

<!--Content-->
@section('content')
    
    <?php if($success): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="success">Banido com sucesso</h1>
            <p><?=$success;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($error): ?>
    <div class="backgroundDark">
        <div class="flash">
            <h1 class="error">Ação negada</h1>
            <p><?=$error;?></p>
            <button class="close btn">Fechar</button>
        </div>
    </div>
    <?php endif; ?>

    <?php if($currentInformation): ?>
    <h1 class="mainTitle"><i class="far fa-bookmark"></i>Tela de Apresentação:</h1>

    <form method="POST" action="<?=$base_url;?>/Painel/salvarTela/inicial">
        @csrf
        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 1</h1>
            <label>Titulo principal:</label>
            <input name="title1" maxlength="38" type="text" value="<?=$currentInformation['title']?>"/>
            <label>Ponto 1:</label>
            <input name="point1" maxlength="38" type="text" value="<?=$currentInformation['point1']?>"/>
            <label>Ponto 2:</label>
            <input name="point2" maxlength="38" type="text" value="<?=$currentInformation['point2']?>"/>
            <label>Ponto 3:</label>
            <input name="point3" maxlength="38" type="text" value="<?=$currentInformation['point3']?>"/>
            <label>Ponto 4:</label>
            <input name="point4" maxlength="38" type="text" value="<?=$currentInformation['point4']?>"/>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 2</h1>
            <label>Titulo:</label>
            <input name="title2" maxlength="68" type="text" value="<?=$currentInformation['title2']?>"/>
            <label>Descrição:</label>
            <textarea name="about"><?=$currentInformation['about']?></textarea>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 3</h1>
            <label>Titulo:</label>
            <input name="title3" maxlength="68" type="text" value="<?=$currentInformation['title3']?>"/>
            <label>Subtitulo 1:</label>
            <input name="subtitle1" maxlength="50" type="text" value="<?=$currentInformation['subTitle1']?>"/>
            <label>Conteúdo 1:</label>
            <textarea name="content1"><?=$currentInformation['content1']?></textarea>
            <br/>
            <label>Subtitulo 2:</label>
            <input name="subtitle2" maxlength="50" type="text" value="<?=$currentInformation['subTitle2']?>"/>
            <label>Conteúdo 2:</label>
            <textarea name="content2"><?=$currentInformation['content2']?></textarea>
            <br/>
            <label>Subtitulo 3:</label>
            <input name="subtitle3" maxlength="50" type="text" value="<?=$currentInformation['subTitle3']?>"/>
            <label>Conteúdo 3:</label>
            <textarea name="content3"><?=$currentInformation['content3']?></textarea>
            <br/>
            <label>Subtitulo 4:</label>
            <input name="subtitle4" maxlength="50" type="text" value="<?=$currentInformation['subTitle4']?>"/>
            <label>Conteúdo 4:</label>
            <textarea name="content4"><?=$currentInformation['content4']?></textarea>
            <br/>
            <label>Subtitulo 5:</label>
            <input name="subtitle5" maxlength="50" type="text" value="<?=$currentInformation['subTitle5']?>"/>
            <label>Conteúdo 5:</label>
            <textarea name="content5"><?=$currentInformation['content5']?></textarea>
        </section>

        <section class="section">
            <h1 class="title"><i class="fas fa-chalkboard"></i>Seção 4</h1>
            <label>Titulo:</label>
            <input name="title4" maxlength="68" type="text" value="<?=$currentInformation['title4']?>"/>
            <label>Sobre 2:</label>
            <textarea name="about2"><?=$currentInformation['about2']?></textarea>
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
    <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
@endsection