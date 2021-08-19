@extends('layouts.struct')
@section('title', 'EnglishVtp')

@section('links')
    <link rel="stylesheet" href="assets/css/home.css" />
@endsection

@section('content')

    <section class="filter">
        <form method="GET">

            <div class="box-filter">
                <div class="field">
                    <h1>Tipo</h1>

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

    <section class="boxContent">
        
        <div class="boxTexts">
            
            <?php if(!empty($texts)): ?>
                <?php foreach ($texts as $text):?>
                    <a href="" class="textSingle">
                        <img src="media/textCover/<?=$text['image'];?>" />
                        <h1><?=$text['title'];?></h1>
                        
                        <b>Nivel:</b> <?=$text['level'];?>
                        <br/>
                        <b>Por:</b> <?=$text['creatorName'];?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="noText">Nenhum texto disponivel com esse filtro.</p>
            <?php endif; ?>
            
        </div>

    </section>

    <div class="btnAssistent">
        <div class="img"></div>
        <p>Sugestão</p>
    </div>

    <div class="assistent animate__animated animate__bounceInUp"></div>
    <div class="assistentTalk animate__animated animate__rubberBand">
        <p>
            Ola, <?=$user->name;?>. Eu ainda não sou capaz de te recomendar nenhum texto, lamento!
        </p>
    </div>
@endsection

@section('scripts')
    <script src="assets/js/home.js"></script>
@endsection