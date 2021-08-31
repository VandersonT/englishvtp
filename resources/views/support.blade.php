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
    <form class="support-form" method="POST" action="<?=$base_url;?>/novoSuporte">
        @csrf
        <?php if(!empty($flash)): ?>
            <div class="flash">
                <i class="fas fa-check-circle"></i>
                <p><?=$flash;?></p>
            </div>
        <?php endif; ?>
        <input required type="text" name="title" placeholder="Titulo"/>
       <textarea name="content" required placeholder="Digite a sua dúvida"></textarea>
        <button>Enviar</button>
    </form>
    
    <section class="mySupports">
        <h1 class="title">Chamados Anteriores</h1>

        <?php  if(!empty($supports)): ?>
            <?php foreach ($supports as $support): ?>
                <a href="<?= $base_url; ?>/suporte/<?= $support['id']; ?>" class="supportSingle">
                    <h1><?= $support['title']; ?></h1>
                    <div class="status <?= ($support['status'] == 'resolvido') ? 'resolved' : 'pending' ?>">
                        <?= $support['status']; ?>
                    </div>
                </a>
            <?php endforeach; ?>

        <?php endif; ?>

    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection