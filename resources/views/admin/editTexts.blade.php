@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - editar textos
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/editTexts.css" />
@endsection

<!--Content-->
@section('content')
   <form class="search" method="GET">
      <input type="text" name="search" placeholder="Procure por algum texto" value="<?=($wantedText != '') ? $wantedText : '';?>"/>
      <button><i class="fas fa-search"></i>Procurar</button>
   </form>

   <h1 class="title">
      <i class="far fa-file-alt"></i>
      <?php if($wantedText == ''):?>
      Todos os textos
      <?php else: ?>
          <?='Encontramos '.count($texts);?>
          <?=(count($texts) > 1) ? ' textos' : ' texto';?>
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
                  <a href="" class="btnEdit">Editar</a>
                  <a href="" class="btnDelete">Apagar</a>
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
@endsection

<!--Scripts-->
@section('scripts')

@endsection