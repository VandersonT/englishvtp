@extends('layouts.struct')

<!--Page title-->
@section('title', 'EnglishVtp - editar perfil')


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/editProfile.min.css" />
@endsection

<!--Content-->
@section('content')
    <div class="boxEditProfile">

        <?php if(!empty($success)): ?>
        <div class="flash success">
            <i class="fas fa-check-circle"></i>
            <?=$success;?>
        </div>
        <?php endif; ?>

        <?php if(!empty($error)): ?>
        <div class="flash error">
            <i class="fas fa-times"></i>
            <?=$error;?>
        </div>
        <?php endif; ?>

        <img src="<?=$base_url;?>/media/avatars/<?=$user['photo'];?>" />
        <form method="POST" action="<?=$base_url;?>/atualizaperfil" enctype="multipart/form-data">
            @csrf
            <input maxlength="100" name="name" type="text" placeholder="Nome" value="<?=$user['name'];?>"/>
            <input disabled maxlength="100" name="email" type="text" placeholder="E-mail" value="<?=$user['email'];?>"/>
            <p class="titleField">Foto de perfil:</p>
            <input name="photo" type="file" />

            <p class="titleField">Thema:</p>

            <div class="boxInputRadio">
                <div class="inputRadio">
                    <input value="dark" name="themeMode" <?=($user['theme'] == 'dark') ? 'checked' : '';?> type="radio" />
                    <p>Dark</p>
                </div>

                <div class="inputRadio">
                    <input value="light" name="themeMode" <?=($user['theme'] == 'light') ? 'checked' : '';?> type="radio" />
                    <p>Light</p>
                </div>
            </div>
            
            <p class="titleField">Qual nivel do seu inglês?</p>
            
            <select name="englishLevel">
                <option disabled <?=($user['level'] == NULL) ? 'selected' : '';?>>Nenhum nível selecionado</option>
                <option value="A1" <?=($user['level'] == 'A1') ? 'selected' : '';?>>A1</option>
                <option value="A2" <?=($user['level'] == 'A2') ? 'selected' : '';?>>A2</option>
                <option value="B1" <?=($user['level'] == 'B1') ? 'selected' : '';?>>B1</option>
                <option value="B2" <?=($user['level'] == 'B2') ? 'selected' : '';?>>B2</option>
                <option value="C1" <?=($user['level'] == 'C1') ? 'selected' : '';?>>C1</option>
                <option value="C2" <?=($user['level'] == 'C2') ? 'selected' : '';?>>C2</option>
            </select>
            
            <div class="boxBtns">
                <a href="<?=$base_url;?>/perfil/<?=$user['id'];?>" class="return">Perfil</a>
                <button class="save">Salvar</button>
            </div>
        </form>
    </div>
@endsection

<!--Scripts-->
@section('scripts')

@endsection