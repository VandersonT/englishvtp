@extends('layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - Suporte "<?=$supportInfo['title'];?>""
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/supportSingle.css" />
@endsection

<!--Content-->
@section('content')
    <h1 class="title"><?=$supportInfo['title'];?></h1>

    <section class="box-comment">
        <div class="commentSingle">
            <div class="box-info">
                <img src="<?=$base_url?>/media/avatars/<?=$user['photo'];?>" />
                <div class="infouser">
                    <p><?=$user['name'];?></p>
                    <span><?=date('d/m/Y H:i', $supportInfo['date']);?></span>
                </div>
            </div>
            <p>
                <?=$supportInfo['content'];?>
            </p>
        </div>
    </section>

    <section class="box-writeAReply">

    </section>

@endsection

<!--Scripts-->
@section('scripts')

@endsection