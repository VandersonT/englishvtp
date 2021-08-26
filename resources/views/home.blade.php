@extends('layouts.struct')
@section('title', 'EnglishVtp - Textos')

@section('links')
    <link rel="stylesheet" href="{{url('assets/css/home.css')}}" />
@endsection

@section('content')

    <section class="filter">
        <form method="GET">

            <div class="box-filter">
                <div class="field">
                    <h1>Inglês</h1>

                    <!--<label>
                        <input <?= ($filter['type'] == 'todos') ? 'checked' : '' ?> name="type" type="radio" value="todos" />
                        Todos
                    </label>
                    <br/>-->
                    <label>
                        <input <?= ($filter['type'] == 'americano') ? 'checked' : '' ?> name="type" type="radio" value="americano" />
                        Americano
                    </label>
                    <br/>
                    <label>
                        <input <?= ($filter['type'] == 'britanico') ? 'checked' : '' ?>  name="type" type="radio" value="britanico" />
                        Britânico
                    </label>

                </div>

                <div class="field">
                    <h1>Nivel</h1>
                    <label>
                        <input <?= ($filter['levels'][0] == 'básico') ? 'checked' : '' ?> name="level1" type="checkbox" value="básico" />
                        Básico
                    </label>
                    <br/>
                    <label>
                        <input <?= ($filter['levels'][1] == 'intermediário') ? 'checked' : '' ?> name="level2" type="checkbox" value="intermediário" />
                        Intermediário
                    </label>
                    <br/>
                    <label>
                        <input <?= ($filter['levels'][2] == 'avançado') ? 'checked' : '' ?> name="level3" type="checkbox" value="avançado" />
                        Avançado
                    </label>
                    <br/>
                    <label>
                        <input <?= ($filter['levels'][3] == 'superavançado') ? 'checked' : '' ?> name="level4" type="checkbox" value="superavançado" />
                        SuperAvançado
                    </label>
                </div>
            </div>

            <div class="btnFilter">
                <button>Filtrar</button>
            </div>
            
        </form>
    </section>
    
    <h1 class="manTitle">
        <i class="fas fa-align-justify"></i>
        Com esse filtro temos <?=$availableTexts;?> <?= ($availableTexts > 1) ? 'textos disponiveis' : 'texto disponivel' ?>
    </h1>

    <section class="boxContent">
        
        <div class="boxTexts">
            
            <?php if(!empty($texts)): ?>
                <?php foreach ($texts as $text):?>
                    <a href="/texto/<?=$text['id'];?>" class="textSingle">
                        <img src="media/textCover/<?=$text['image'];?>" />
                        <h1><?=$text['title'];?></h1>
                        
                        <b>Nivel:</b> <?=$text['level'];?>
                        <br/>
                        <b>Por:</b> <?=$text['creator'];?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="noText">Nenhum texto disponivel com esse filtro.</p>
            <?php endif; ?>
            
        </div>

    </section>

    <?php if($totalPage > 1): ?>
    <ul class="box-pagination">
        <?php for($q=1; $q<=$totalPage; $q++): ?>
        <a href="/?<?php 
        $currentUrl = $_GET;
        $currentUrl['pg'] = $q;
        echo http_build_query($currentUrl);
        ?>"><li class="<?=($q == $page) ? 'paginationSelected' : ''?>"> <?=$q?> </li></a>
        <?php endfor; ?>
    </ul>
    <?php endif; ?>

    <div class="btnAssistent">
        <div class="img"></div>
        <p>Sugestão</p>
    </div>

    <div class="assistent animate__animated animate__bounceInUp"></div>
    <div class="assistentTalk animate__animated animate__rubberBand">
        <?php if($user['level'] == NULL): ?>
            <p>
                Ola, <?=$user->name;?>. Antes que eu possa te sugerir algum texto, você deve informar seu nivel atual lá no seu perfil 
                <i class="far fa-smile-wink"></i>
            </p>
        <?php else: ?>
            <p>1 minutinho que eu já vejo</p>
        <?php endif; ?>
    </div>
@endsection

@section('scripts')
    <script src="{{url('assets/js/home.js')}}"></script>
@endsection