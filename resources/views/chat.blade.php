@extends('layouts.struct')

<!--Page title-->
@section('title', 'EnglishVtp - chat')


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/chats.css" />
@endsection

<!--Content-->
@section('content')
    <h1 class="mainTitle">
        <i class="fas fa-comment-dots"></i>
        Seus chats
    </h1>

    <div class="boxChats">

        <?php if(count($chats) > 0): ?>
            <?php foreach ($chats as $chat):?>
                <div class="chatSingle">
                    <img src="<?=$base_url?>/media/avatars/<?=$chat['photo'];?>" />
                    <div class="infoChat">
                        <div>
                            <span class="name"><?=$chat['friend'];?></span>
                            <span class="newMsg">
                                3
                            </span>
                        </div>
                        <p>
                            <?=$chat['lastConversation'];?>
                        </p>
                        <p>
                            <?=date('d/m/Y H:i', $chat['date']);?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!--
        <h1 class="noMsg">
            <i class="fas fa-exclamation-circle"></i>
            Você ainda não iniciou nenhuma conversa com nenhum usuário
        </h1>
        -->

    </div>
@endsection

<!--Scripts-->
@section('scripts')

@endsection