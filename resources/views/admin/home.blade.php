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

    <section class="box-charts">
        <div class="chartSingle">
            <h1 class="title2">
                <i class="fas fa-align-left"></i>
                Textos mais Salvados
            </h1>
            <canvas id="myChart" width="400" height="250"></canvas>
        </div>
        <div class="chartSingle">
            <h1 class="title2">
                <i class="fas fa-align-left"></i>
                Textos mais estudados
            </h1>
            <canvas id="myChart2" width="400" height="250"></canvas>
        </div>
    </section>

    <section class="guide">
        <h1 class="title">
            <i class="fab fa-guilded"></i>
            Guia do Painel
        </h1>
        <h4><i class="fas fa-pager"></i>Dasboard:</h4>
        <p>Nesta página você tem acesso a informações importantes sobre o andamento do sistema, com isso sabe quais as proximas ações tomar. Lá também você pode tomar medidas urgentes, como trancar todo o sistema ou  todo o suporte ou reporte.</p>
        <span>(Moderadores/Administradores)</span>
        <h4><i class="fas fa-pager"></i>Páginas:</h4>
        <p>Nesta aba você tem o controle sobre todas as paginas do sistema, lá é possivel editar o layout de todas as páginas existentes no sistema, desde cores até funcionalidades.</p>
        <span>(Moderadores/administradores)</span>
        <h4><i class="fas fa-pager"></i>Usuários</h4>
        <p>Nesta aba você tem o controle sobre todos os usuários do sistema, desde promover à punir alguém. Lá você pode ver todos os usuários, membros da staff, banidos e exilados e nestes 3 últimos podem ser adicionados novos usuários.</p>
        <span>(Ajudantes/Moderadores/administradores)</span>
        <h4><i class="fas fa-pager"></i>Textos</h4>
        <p>Nesta aba você pode adicionar novos textos para o sistema ou editar algum do que já existem.</p>
        <span>(Moderadores/Administradores)</span>
        <h4><i class="fas fa-pager"></i>Reportes</h4>
        <p>Nesta aba você tem acesso a todos os comentários que foram reportados, podendo analizar e tomar alguma atitude, também pode ver todos os casos que já foram resolvidos ou que foram ignorados.</p>
        <span>(Ajudantes/Moderadores/Administradores)</span>
        <h4><i class="fas fa-pager"></i>Suporte</h4>
        <p>Nesta aba você tem acesso a todos os chamados enviados pelos usuários, é lá que você ajudará eles, respondendo duvidas ou resolvendo alguma situação, podendo também analizar todos os chamados já resolvidos antes ou ignorados.</p>
        <span>(Ajudantes/Moderadores/Administradores)</span>
    </section>

    <section class="box-controls">
        <h1 class="title">
            <i class="fab fa-guilded"></i>
            Controles Principais
        </h1>

        <div class="box-btns">
            <a class="btnSingle on">Sistema: On</a>
            <a class="btnSingle on">Reportes: On</a>
            <a class="btnSingle on">Comentários: On</a>
            <a class="btnSingle off">Suporte: Off</a>
        </div>

    </section>
@endsection

<!--Scripts-->
@section('scripts')
    <script>
        /*info saved texts*/
        let savedName1 = 'teste1';
        let savedName2 = 'teste2';
        let savedName3 = 'teste3';
        let savedName4 = 'teste4';
        let savedName5 = 'teste5';

        let savedValue1 = 100;
        let savedValue2 = 200;
        let savedValue3 = 300;
        let savedValue4 = 400;
        let savedValue5 = 500;

        /*info studied texts*/
        let studiedName1 = 'teste1';
        let studiedName2 = 'teste2';
        let studiedName3 = 'teste3';
        let studiedName4 = 'teste4';
        let studiedName5 = 'teste5';

        let studiedValue1 = 100;
        let studiedValue2 = 200;
        let studiedValue3 = 300;
        let studiedValue4 = 400;
        let studiedValue5 = 500;

    </script>
@endsection