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

        <div class="chatSingle">
            <img src="media/avatars/no-picture2.png" />
            <div class="infoChat">
                
                <div>
                    <span class="name">Suporte [2]</span>
                </div>
                
                <p>
                    Eu não sei o que te dizer e isso posso te dizer que eu sou amigo teu assim eu vou te contar tudo que houve aqui meu amigaozao, lembra desta musica? do amigaozao?
                </p>
                <p>
                    12/02/2022 12:00
                </p>
            </div>
        </div>

        <div class="chatSingle">
            <img src="media/avatars/no-picture2.png" />
            <div class="infoChat">
                <div>
                    <span class="name">Amanda Silva [3]</span>
                </div>
                <p>
                    Oie, tudo bom?
                </p>
                <p>
                    12/02/2022 12:00
                </p>
            </div>
        </div>

        <div class="chatSingle notSeen">
            <img src="media/avatars/no-picture2.png" />
            <div class="infoChat">
                <div>
                    <span class="name">Pedro Oliveira [1]</span>
                    <span class="newMsg">
                        3
                    </span>
                </div>
                <p>
                    Salve, irmão
                </p>
                <p>
                    12/02/2022 12:00
                </p>
            </div>
        </div>

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