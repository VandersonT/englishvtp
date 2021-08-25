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

    <?php if(!empty($flash)): ?>
    <div class="flash animate__animated animate__slideInRight">
        <i class="fas fa-check"></i>
        <p><?=$flash;?></p>
        <button>Fechar</button>
    </div>
    <?php endif;?>

    <section class="menuAction">
        <a class="btnReturn" href="#" onClick="return window.history.back();">Voltar</a>
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
            <source src="<?= $base_url;?>/media/audio/<?=$text['audio'];?>" type="audio/mp3">
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
        <h1 class="boxComments-title">Comentarios: {{$totalComments}}</h1>
        <div class="boxNewComment">
            <img src="<?= $base_url;?>/media/avatars/<?= $user['photo']?>" />
            <a name="form-anchor"></a>
            <form class="formNewMsg" method="POST" action="<?=$base_url;?>/envianovocomentario">
                @csrf
                <input type="hidden" name="textid" value="<?=$text['id']?>" />
                <textarea class="sendnewComment" name="newcomment" placeholder="Digite um comentario"></textarea>
                <button class="button mainComment">Enviar</button>
            </form>
        </div>

        <div class="Featured">
            
        </div>

        <?php foreach ($comments as $comment):?>
       
            <div class="boxCommentSingle" data-id="<?=$comment['id']?>" typec="normal">
                <img src="<?= $base_url;?>/media/avatars/<?= $comment['photo']?>" />
                <div class="comment">

                    <div class="infoComment">
                        <a href="#"><?= $comment['user_name'];?></a>
                        <span><?=date('d/m/Y - H:i', $comment['last_update']);?></span>
                    </div>
                    
                    <p>{{$comment['comment']}}</p>  
                    <div class="commentRate">
                        <a class="commentIcon">
                            <i class="btnLike fas fa-thumbs-up <?= ($comment['userRated'] == 1) ? 'liked' : ''; ?>"></i>
                            <span class="numberLike">{{$comment['likes']}}</span>
                        </a>
                        <a class="commentIcon">
                            <i class="btnUnlike fas fa-thumbs-down <?= ($comment['userRated'] == -1) ? 'unliked' : '' ?>"></i>
                            <span class="numberUnlike">{{$comment['unlikes']}}</span>
                        </a>
                        <a href="#comment" class="commentIcon">
                            <i class="fas fa-comment-alt"></i>
                            <span>{{$comment['subcomments']}}</span>
                        </a>
                        <a href="#report" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                            <i class="fas fa-flag"></i>
                        </a>
                        <?php if($user['id'] == $comment['user_id'] || $user['access'] > 1):?>
                        <a href="<?=$base_url;?>/deletap/comentario/<?=$comment['id'];?>" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <?php endif; ?>
                        <a class="commentIcon btnActiveComment">
                            responder
                        </a>
                    </div>  
                </div>
            </div>
            
            <?php if($comment['subcomments']): ?>
            <div class="boxGeneral animate__animated animate__fadeIn">
            <?php endif; ?>
                
                <?php foreach ($subComments as $subComment):?>
                    <?php if($subComment['comment_answered'] == $comment['id']): ?>
                        <div class="boxCommentSingle subComment" data-id="<?=$subComment['id']?>" typec="sub">
                            <img src="<?= $base_url;?>/media/avatars/<?= $subComment['photo']?>" />
                            <div class="comment">
                                
                                <div class="infoComment">
                                    <a href="#"><?= $subComment['user_name'];?></a>
                                    <span><?=date('d/m/Y - H:i', $subComment['last_update']);?></span>
                                </div>
                                
                                <p>{{$subComment['comment']}}</p> 

                                <div class="commentRate">
                                    <a class="commentIcon">
                                        <i class="btnLike fas fa-thumbs-up <?= ($subComment['userRated'] == 1) ? 'liked' : '' ?>"></i>
                                        <span class="numberLike">
                                            {{$subComment['likes']}}
                                        </span>
                                    </a>
                                    <a class="commentIcon">
                                        <i class="btnUnlike fas fa-thumbs-down <?= ($subComment['userRated'] == -1) ? 'unliked' : '' ?>"></i>
                                        <span class="numberUnlike">
                                            {{$subComment['unlikes']}}
                                        </span>
                                    </a>
                                    <a href="" onClick="return confirm('Quer denunciar esse comentário aos administradores?')" class="commentIcon report">
                                        <i class="fas fa-flag"></i>
                                    </a>
                                    <?php if($user['id'] == $subComment['user_id'] || $user['access'] > 1):?>
                                    <a href="<?=$base_url;?>/deletap/subcomentario/<?=$subComment['id'];?>" onClick="return confirm('Você quer realmente apagar esse comentário?')" class="commentIcon delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>  
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php if($comment['subcomments']): ?>
            </div>
            <?php endif; ?>

            <?php if($comment['subcomments']): ?>
                <div class="seeMore">Ver Respostas</div>
                <div class="seeLess">Ocultar Respostas</div>
            <?php endif; ?>

            <div class="boxNewComment subNewComment">
                <img src="<?= $base_url;?>/media/avatars/<?= $user['photo']?>" />
                <form class="formNewMsg" method="POST" action="<?=$base_url;?>/envianovosubcomentario">
                    @csrf
                    <input name="text" type="hidden" value="<?=$text['id']?>" />
                    <input name="comment" type="hidden" value="<?=$comment['id']?>" />
                    <textarea name="newSubComment" class="newMsg" placeholder="Digite um comentario"></textarea>
                    <button class="button">Enviar</button>
                </form>
            </div>

        <?php endforeach; ?>

        <?php if($totalPages > 1): ?>
        <ul class="box-pagination">
            <?php for($q=1; $q <= $totalPages; $q++): ?>

                <a href="<?=$base_url;?>/texto/<?=$text['id'];?>?pg=<?=$q;?>">
                    <li class="<?=($q == $page) ? 'paginationSelected' : ''?>"><?php echo $q?></li>
                </a>

            <?php endfor; ?>
        </ul>
        <?php endif; ?>

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
    <script type="text/javascript">
        let base_url = '<?=$base_url;?>';
    </script>
    <script src="{{url('assets/js/textReading.js')}}"></script>
    <script src="{{url('assets/js/commentsInfo.js')}}"></script>
@endsection