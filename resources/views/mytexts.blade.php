@extends('layouts.struct')

<!--Page title-->
@section('title', 'EnglishVtp - meus textos')


<!--Links-->
@section('links')
    <link rel="stylesheet" href="assets/css/myTexts.min.css" />
@endsection

<!--Content-->
@section('content')
        
    <h1 class="title"><i class="far fa-save"></i>Textos Salvos</h1>
    <section class="savedTexts">
        
        <div class="showcase">
            
            <?php if(count($textsSaveds) > 0): ?>
                <?php foreach($textsSaveds as $textsSaved): ?>
                    <div class="textSavedSingle">
                        <img src="<?=$base_url;?>/media/textCover/<?=$textsSaved['image'];?>" />
                        <h3><?=$textsSaved['english_title'];?></h3>
                        <p>Nivel: <?=$textsSaved['level'];?></p>

                        <div class="btnsGroup">
                            <a class="openText" href="<?=$base_url;?>/texto/<?=$textsSaved['textid'];?>">Abrir</a>
                            <a class="deleteText" href="<?=$base_url;?>/salvartexto/<?=$textsSaved['textid'];?>">Remover</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="noText">Você ainda não salvou nenhum texto.</p>
            <?php endif; ?>

        </div>

    </section>

    <h1 class="title"><i class="fab fa-studiovinari"></i>Textos estudados</h1>

    <section class="textsStudied">

        <?php if(count($textsStudies) > 0): ?>
            <?php foreach ($textsStudies as $textsStudie):?>
                <div class="textSavedSingle">
                    <img src="<?=$base_url;?>/media/textCover/<?= $textsStudie['image'];?>" />
                    <h3><?= $textsStudie['english_title'];?></h3>
                    <p>Nivel: <?= $textsStudie['level'];?></p>

                    <div class="btnsGroup">
                        <a class="openText" href="<?=$base_url;?>/texto/<?=$textsStudie['textid'];?>">Abrir</a>
                        <a class="deleteText" href="<?=$base_url;?>/finalizarEstudo/<?=$textsStudie['textid'];?>">Remover</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="noText">Você ainda não estudou nenhum texto.</p>
        <?php endif; ?>

    </section>
    <?php if($totalPages > 1): ?>
        <ul class="box-pagination">
            <?php for($q=1; $q <= $totalPages; $q++): ?>

                <a href="<?=$base_url;?>/meustextos?pg=<?=$q;?>">
                    <li class="<?=($q == $page) ? 'paginationSelected' : ''?>"><?php echo $q?></li>
                </a>

            <?php endfor; ?>
        </ul>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')

@endsection