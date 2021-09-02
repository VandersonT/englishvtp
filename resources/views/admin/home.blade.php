@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   Painel - Dashboard
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/dashboard.css" />
@endsection

<!--Content-->
@section('content')
    <!--<canvas id="myChart" width="400" height="400"></canvas>-->
    <h1 class="title">Dashboard</h1>
    <section class="box-dashboard">
        <div class="infoSingle blue">
            <div class="info">
                <p class="number">779</p>
                <p>Acessos</p>
            </div>
            <div class="img">
                <i class="far fa-eye"></i>
            </div>
        </div>
        <div class="infoSingle green">
            <div class="info">
                <p class="number">52</p>
                <p>Online</p>
            </div>
            <div class="img">
                <i class="far fa-heart"></i>
            </div>
        </div>
        <div class="infoSingle yellow">
            <div class="info">
                <p class="number">134</p>
                <p>Textos</p>
            </div>
            <div class="img">
                <i class="far fa-file-alt"></i>
            </div>
        </div>
        <div class="infoSingle red">
            <div class="info">
                <p class="number">553</p>
                <p>Contas</p>
            </div>
            <div class="img">
                <i class="far fa-user"></i>
            </div>
        </div>
    </section>
@endsection

<!--Scripts-->
@section('scripts')

@endsection