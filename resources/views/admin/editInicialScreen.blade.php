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
    <h1 class="mainTitle"><i class="far fa-bookmark"></i>Tela de Apresentação:</h1>
    
    <form method="POST">
        <section class="section1">
            <h1 class="title">Seção 1</h1>
            <label for="mainTitle">Titulo principal:</label>
            <input maxlength="36" id="mainTitle" type="text" />
            <label for="point1">Ponto 1:</label>
            <input maxlength="36" id="point1" type="text" />
            <label for="point2">Ponto 2:</label>
            <input maxlength="36" id="point2" type="text" />
            <label for="point3">Ponto 3:</label>
            <input maxlength="36" id="point3" type="text" />
            <label for="point4">Ponto 4:</label>
            <input maxlength="36" id="point4" type="text" />
        </section>

        <section class="section2">

        </section>

        <section class="section3">

        </section>

        <section class="section4">

        </section>
        <button>Concluir</button>
    </form>

@endsection

<!--Scripts-->
@section('scripts')

@endsection