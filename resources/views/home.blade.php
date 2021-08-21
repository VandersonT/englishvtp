@extends('layouts.struct')
@section('title', 'EnglishVtp - Textos')

@section('links')
    <link rel="stylesheet" href="{{url('assets/css/home.css')}}" />
@endsection

@section('content')

    <section class="filter">
        <form method="GET">

            <?php
                $teste = $_SERVER["REQUEST_URI"];
                echo 'Url Atual: '.$teste;    
            ?>

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

    <ul class="box-pagination">
        <?php for($q=1; $q<=$totalPage; $q++): ?>
        <a href="/?pg=<?=$q;?>"><li class="<?=($q == $page) ? 'paginationSelected' : ''?>"> <?=$q?> </li></a>
        <?php endfor; ?>
    </ul>

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
    <script src="{{url('assets/js/home.js')}}"></script>
@endsection