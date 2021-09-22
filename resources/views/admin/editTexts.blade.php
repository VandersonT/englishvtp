@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - Editar textos
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/editTexts.min.css" />
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/flash.min.css" />
@endsection

<!--Content-->
@section('content')

   <?php if($success): ?>
   <div class="backgroundDark">
      <div class="flash">
         <h1 class="success">Feito</h1>
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

   <form class="search" method="GET">
      <input type="text" name="search" placeholder="Procure por algum texto" value="<?=($wantedText != '') ? $wantedText : '';?>"/>
      <button><i class="fas fa-search"></i>Procurar</button>
   </form>

   <h1 class="title">
      <i class="far fa-file-alt"></i>
      <?php if($wantedText == ''):?>
      Todos os textos
      <?php else: ?>
          <?='Encontramos '.$totalTexts;?>
          <?=($totalTexts > 1) ? ' textos' : ' texto';?>
          <?=' com "'.$wantedText.'"';?>
      <?php endif; ?>
  </h1>

   <section class="box-texts">
      <?php if(count($texts) > 0): ?>
         <?php foreach($texts as $text): ?>
            <div class="textSingle">
               <img src="<?=$base_url;?>/media/textCover/<?=$text['image'];?>" />
               <h1><?=$text['english_title'];?></h1>
               <div class="box-btns">
                  <a href="<?=$base_url;?>/Painel/editarTexto/<?=$text['id'];?>" class="btnEdit">Editar</a>
                  <a href="<?=$base_url;?>/Painel/removeTexto/<?=$text['id'];?>" class="btnDelete" onClick="return confirm('Você tem certeza que quer apagar este texto?');">Apagar</a>
               </div>
            </div>
         <?php endforeach; ?>
      <?php else: ?>
         <div class="empty">
            <h1 >
               <i class="far fa-frown"></i>
               Nenhum texto foi encontrado
            </h1>
         </div>
      <?php endif; ?>

   </section>

   <?php if($totalPages > 1): ?>
        <ul class="box-pagination">
            <?php for($q=1; $q<=$totalPages; $q++): ?>
            <a href="/Painel/editarTextos?<?php 
            $currentUrl = $_GET;
            $currentUrl['pg'] = $q;
            echo http_build_query($currentUrl);
            ?>"><li class="<?=($q == $page) ? 'paginationSelected' : ''?>"> <?=$q?> </li></a>
            <?php endfor; ?>
        </ul>
      <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')
   <script src="<?=$base_url;?>/assets/js/admin/flash.min.js"></script>
@endsection