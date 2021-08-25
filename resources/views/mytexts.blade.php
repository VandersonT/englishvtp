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
            
            <?php if(count($textsSaveds) > 0): ?>
                <?php foreach($textsSaveds as $textsSaved): ?>
                    <div class="textSavedSingle">
                        <img src="<?=$base_url;?>/media/textCover/<?=$textsSaved['image'];?>" />
                        <h3><?=$textsSaved['english_title'];?></h3>
                        <p>Nivel: <?=$textsSaved['level'];?></p>

                        <div class="btnsGroup">
                            <a class="openText" href="">Abrir</a>
                            <a class="deleteText" href="">Apagar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="noText">Você ainda não salvou nenhum texto.</p>
            <?php endif; ?>

        </div>

    </section>

    <h1 class="title">Textos estudados</h1>

    <section class="textsStudied">

        <?php if(count($textsStudies) > 0): ?>
            <?php foreach ($textsStudies as $textsStudie):?>
                <div class="textSavedSingle">
                    <img src="<?=$base_url;?>/media/textCover/<?= $textsStudie['image'];?>" />
                    <h3><?= $textsStudie['english_title'];?></h3>
                    <p>Nivel: <?= $textsStudie['level'];?></p>

                    <div class="btnsGroup">
                        <a class="openText" href="">Abrir</a>
                        <a class="deleteText" href="">Apagar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="noText">Você ainda não estudou nenhum texto.</p>
        <?php endif; ?>

    </section>

@endsection

<!--Scripts-->
@section('scripts')

@endsection