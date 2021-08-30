@extends('layouts.struct')

<!--Page title-->
@section('title')
EnglishVtp - chat com X
@endsection


<!--Links-->
@section('links') 
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/chatSingle.css" />
@endsection

<!--Content-->
    @section('content')
    <header class="headerUser">
                
        <img src="<?=$base_url?>/media/avatars/<?=$friendInfo['photo'];?>" />
        <a href="<?=$base_url?>/perfil/<?=$friendInfo['id'];?>" class="name"><?=$friendInfo['user_name'];?></a>
        <i class="fas fa-ellipsis-v btnMenu"></i>

        <nav class="menu">
            <ul>
                <a href=""><li>Bloquear</li></a>
                <a href="<?=$base_url?>/perfil/<?=$friendInfo['id'];?>"><li>Ver perfil</li></a>
            </ul>
        </nav>

    </header>

    <section class="boxChat">

        <?php if(count($conversations) > 0): ?>

            <?php foreach ($conversations as $conversation):?>

                <?php if($conversation['user_from'] == $user['id']): ?>
                    <div class="rightMsg">
                        <div class="msg">
                            <?=$conversation['message'];?>
                        </div>
                        <img src="<?=$base_url?>/media/avatars/<?=$user['photo'];?>" />
                    </div>
                <?php else: ?>
                    <div class="leftMsg">
                        <img src="<?=$base_url?>/media/avatars/<?=$friendInfo['photo'];?>" />
                        <div class="msg">
                            <?=$conversation['message'];?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        <?php endif; ?>

    </section>

    <section class="writeMsg">
        <form>
            <textarea placeholder="Escreva uma mensagem" name="" id="" cols="30" rows="10"></textarea>
            <button>Enviar</button>
        </form>
    </section>
@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url?>/assets/js/chatSingle.js"></script>
@endsection