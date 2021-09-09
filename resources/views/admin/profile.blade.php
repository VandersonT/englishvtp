@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - nome aqui
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/profile.css" />
@endsection

<!--Content-->
@section('content')
    <section class="view">
        <h1 class="title">
            <i class="fas fa-id-card-alt"></i>
            Perfil de Vanderson
        </h1>
        <div class="box-info">
            <img src="<?=$base_url;?>/media/avatars/no-picture2.png" />
            
            <h1 class="title">Informações Básicas</h1>

            <div class="info">
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-id-card"></i>
                        Id:
                    </h1>
                    <p>1</p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-file-signature"></i>
                        Nome:
                    </h1>
                    <p>Vanderson Tiago de Paulo</p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-envelope"></i>
                        Email:
                    </h1>
                    <p>vandersonoliveiradasilvapinho12@gmail.com</p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-briefcase"></i>
                        Cargo:
                    </h1>
                    <p>Administrador</p>
                </div>
                <div class="infoSingle">
                    <h1 class="title2">
                        <i class="fas fa-level-up-alt"></i>
                        Nivel:
                    </h1>
                    <p>A1</p>
                </div>
                <a href="<?=$base_url;?>/perfil/1" class="button">Ver perfil no sistema</a>
            </div>
        </div>
    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection