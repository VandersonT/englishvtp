@extends('layouts.struct')

<!--Page title-->
@section('title', 'EnglishVtp - Suporte')


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/support.css" />
@endsection

<!--Content-->
@section('content')
    <h1 class="title">Novo chamado</h1>
    <form class="support-form" method="POST" action="">
        <input type="text" name="title" placeholder="Titulo"/>
       <textarea placeholder="Digite a sua dúvida"></textarea>
        <button>Enviar</button>
    </form>
    
    <section class="mySupports">
        <h1 class="title">Chamados Anteriores</h1>

        <a href="" class="supportSingle">
            <h1>Como que eu faço para falar inglês bem?</h1>
            <div class="status resolved">
                resolvido
            </div>
        </a>

        <a href="" class="supportSingle">
            <h1>O que que significa 'brunch'?</h1>
            <div class="status pending">
                pendente
            </div>
        </a>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection