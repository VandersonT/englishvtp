@extends('layouts.struct')

<!--Page title-->
@section('title')
EnglishVtp - <?=$text['englishTitle'];?>
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="{{url('assets/css/textReading.css')}}" />
@endsection

<!--Content-->
@section('content')
    <section class="menuAction">
        <a class="btnReturn" href="{{url()->previous()}}">Voltar</a>
        <a class="btnOrange" href="#">Finalizar Estudo</a>
        <a class="btnGreen" href="#">Salvar</a>
    </section>

    <section class="infoText">
        <h1><?=$text['englishTitle'];?></h1>
        <div class="boxSubInfo">
            <p>
                <b>Nivel:</b>
                <?=$text['level'];?>
            </p>
            <p>
                <b>Publicado:</b>
                <?=$text['created'];?>
            </p>
            <p>
                <b>By:</b>
                <?=$text['creatorName'];?>
            </p>
        </div>
    </section>

    <section class="boxAudio">
        <h1 class="title">Aúdio do texto</h1>
        <audio controls>
            <source src="/media/audio/<?=$text['audio'];?>" type="audio/mp3">
        </audio>
    </section>

    <section class="boxTexts">
        <h1 class="title spaceBottom">Texto com tradução</h1>
        
        <div class="boxTextsSingle">

            <div class="text">
                <h1><?=$text['englishTitle'];?></h1>
                <p><?=$text['englishContent'];?></p>
            </div>

            <div class="text">
                <h1><?=$text['translatedTitle'];?></h1>
                <p><?=$text['translatedContent'];?></p>
            </div>

        </div>

    </section>

    <section class="boxComments">
        <h1 class="boxComments-title">Comentarios: 100</h1>

        <div class="boxNewComment">
            <img src="/media/avatars/<?=$user['photo'];?>" />
            <form>
                <textarea placeholder="Digite um comentario"></textarea>
            </form>
        </div>

        <div class="boxCommentSingle">
            <img src="media/avatars/no-picture2.png" />
            <div class="comment">
                <h1>Sergio Dark [22] - 1 hora atras</h1>
                <p>
                    Gostei muito
                </p>  
                <div class="commentRate">
                    <a class="commentIcon">
                        <i class="btnLike fas fa-thumbs-up"></i>
                        <span class="numberLike">6</span>
                    </a>
                    <a class="commentIcon">
                        <i class="btnUnlike fas fa-thumbs-down"></i>
                        <span class="numberUnlike">0</span>
                    </a>
                    <a href="#report" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                        <i class="fas fa-flag"></i>
                    </a>
                    <a href="#" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <a class="commentIcon btnActiveComment">
                        responder
                    </a>
                </div>  
            </div>
        </div>

        <div class="boxCommentSingle subComment">
            <img src="media/avatars/no-picture2.png" />
            <div class="comment">
                <h1>Izabella Pimenta [20] - 1 hora atras</h1>
                <p>
                    Me ajudou muito!! é meu terceiro texto
                </p>  
                <div class="commentRate">
                    <a class="commentIcon">
                        <i class="btnLike fas fa-thumbs-up"></i>
                        <span class="numberLike">2</span>
                    </a>
                    <a class="commentIcon">
                        <i class="btnUnlike fas fa-thumbs-down"></i>
                        <span class="numberUnlike">0</span>
                    </a>
                    <a href="" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                        <i class="fas fa-flag"></i>
                    </a>
                    <a href="" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>  
            </div>
        </div>

        <div class="boxCommentSingle subComment">
            <img src="media/avatars/no-picture2.png" />
            <div class="comment">
                <h1>Amanda Pimenta [5] - 30 minutos atras</h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget mattis leo. Nulla sit amet nunc id justo scelerisque mollis at ac neque. Morbi commodo, risus sit amet pharetra interdum, sem metus consectetur neque, eget tristique nisi tortor et urna. Nullam elementum sollicitudin ornare. Etiam congue, tellus lacinia consectetur dictum, elit odio finibus lorem, viverra dignissim lorem eros et turpis. Proin dapibus dapibus lacus, sed aliquam libero. Etiam rhoncus orci eu massa gravida, in feugiat sapien cursus. Phasellus egestas enim vel imperdiet egestas.
                </p>  
                <div class="commentRate">
                    <a class="commentIcon">
                        <i class="btnLike fas fa-thumbs-up"></i>
                        <span class="numberLike">2</span>
                    </a>
                    <a class="commentIcon">
                        <i class="btnUnlike fas fa-thumbs-down"></i>
                        <span class="numberUnlike">1</span>
                    </a>
                    <a href="" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                        <i class="fas fa-flag"></i>
                    </a>
                    <a href="" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>  
            </div>
        </div>

        <div class="boxNewComment subNewComment">
            <img src="/media/avatars/<?=$user['photo'];?>" />
            <form>
                <textarea placeholder="Digite um comentario"></textarea>
            </form>
        </div>

        <div class="boxCommentSingle">
            <img src="media/avatars/no-picture2.png" />
            <div class="comment">
                <h1>Isah Pimenta [2] - 5 hora atras</h1>
                <p>
                    Muito bom to evoluindo
                </p>  
                <div class="commentRate">
                    <a class="commentIcon">
                        <i class="btnLike fas fa-thumbs-up"></i>
                        <span class="numberLike">6</span>
                    </a>
                    <a class="commentIcon">
                        <i class="btnUnlike fas fa-thumbs-down"></i>
                        <span class="numberUnlike">0</span>
                    </a>
                    <a href="#d" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                        <i class="fas fa-flag"></i>
                    </a>
                    <a href="" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <a class="commentIcon btnActiveComment">
                        responder
                    </a>
                </div>  
            </div>
        </div>

        <div class="boxNewComment subNewComment">
            <img src="/media/avatars/<?=$user['photo'];?>" />
            <form>
                <textarea autofocus placeholder="Digite um comentario"></textarea>
            </form>
        </div>

    </section>

    <div class="btnAssistent">
        <div class="img"></div>
        <p>Dúvida</p>
    </div>

    <div class="assistent animate__animated animate__bounceInUp"></div>
    <div class="assistentTalk animate__animated animate__rubberBand">
        <p>
            Se você gostar do texto, você pode ir no topo da página e clicar em 'Salvar', assim ele irá ser salvo na sua coleção e você não o perderá.<br/>
            Quando você terminar de estudar um texto, vá no topo da página e clique em 'Finalizar estudo', assim os pontos de experiência que o texto vale, serão acrescentados na sua experiência total e me ajudará a te indicar os textos mais proximos do seu nivel quando você me solicitar.
        </p>
    </div>
@endsection

<!--Scripts-->
@section('scripts')
    <script src="{{url('assets/js/textReading.js')}}"></script>
    <script src="{{url('assets/js/commentsInfo.js')}}"></script>
@endsection