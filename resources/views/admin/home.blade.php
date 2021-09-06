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
                <p class="number"><?=$totalAccess;?></p>
                <p><?=($totalAccess > 1) ? 'Acessos' : 'Acesso'?></p>
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
                <p class="number"><?=$totalTexts;?></p>
                <p><?=($totalTexts > 1) ? 'Textos' : 'Texto'?></p>
            </div>
            <div class="img">
                <i class="far fa-file-alt"></i>
            </div>
        </div>
        <div class="infoSingle red">
            <div class="info">
                <p class="number"><?=$totalAccounts;?></p>
                <p><?=($totalAccounts > 1) ? 'Contas' : 'Conta'?></p>
            </div>
            <div class="img">
                <i class="far fa-user"></i>
            </div>
        </div>
    </section>

    <section class="box-charts">
        <div class="chartSingle">
            <h1 class="title2">
                <i class="fas fa-save"></i>
                Textos mais Salvados
            </h1>
            <canvas id="myChart" width="400" height="250"></canvas>
        </div>
        <div class="chartSingle">
            <h1 class="title2">
                <i class="fas fa-user-graduate"></i>
                Textos mais estudados
            </h1>
            <canvas id="myChart2" width="400" height="250"></canvas>
        </div>
        <div class="chartSingle">
            <h1 class="title2">
                <i class="fas fa-adjust"></i>
                Quantidades adicionadas [Americano Vs Britânico]
            </h1>
            <canvas id="myChart3" width="400" height="250"></canvas>
        </div>
    </section>

    <section class="box-userOn">
        <h1 class="title">
            <i class="fab fa-guilded"></i>
            Usuários Online
        </h1>

        <table class="boxUsers">
            <tr>
                <th>Id</th>
                <th>Usuário</th>
                <th>Último acesso</th>
            </tr>
            <tr>
                <td>2</td>
                <td>Matheus Vilela</td>
                <td>20/01/2021 11:00</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Vanderson Lindão</td>
                <td>20/01/2021 11:10</td>
            </tr>
        </table>

    </section>

    <section class="guide">
        <h1 class="title">
            <i class="fab fa-guilded"></i>
            Guia do Painel
        </h1>
        <h4><i class="fas fa-chart-line"></i>Dasboard:</h4>
        <p>Nesta página você tem acesso a informações importantes sobre o andamento do sistema, com isso sabe quais as proximas ações tomar. Lá também você pode tomar medidas urgentes, como trancar todo o sistema ou  todo o suporte ou reporte.</p>
        <span>(Moderadores/Administradores)</span>
        <h4><i class="far fa-file-alt"></i>Páginas:</h4>
        <p>Nesta aba você tem o controle sobre todas as paginas do sistema, lá é possivel editar o layout de todas as páginas existentes no sistema, desde cores até funcionalidades.</p>
        <span>(Moderadores/administradores)</span>
        <h4><i class="far fa-user"></i>Usuários:</h4>
        <p>Nesta aba você tem o controle sobre todos os usuários do sistema, desde promover à punir alguém. Lá você pode ver todos os usuários, membros da staff, banidos e exilados e nestes 3 últimos podem ser adicionados novos usuários.</p>
        <span>(Ajudantes/Moderadores/administradores)</span>
        <h4><i class="fas fa-align-left"></i>Textos:</h4>
        <p>Nesta aba você pode adicionar novos textos para o sistema ou editar algum do que já existem.</p>
        <span>(Moderadores/Administradores)</span>
        <h4><i class="fas fa-exclamation"></i>Reportes:</h4>
        <p>Nesta aba você tem acesso a todos os comentários que foram reportados, podendo analizar e tomar alguma atitude, também pode ver todos os casos que já foram resolvidos ou que foram ignorados.</p>
        <span>(Ajudantes/Moderadores/Administradores)</span>
        <h4><i class="fas fa-headset"></i>Suporte:</h4>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        /*info saved texts*/
        var savedName1 = '<?=$mostSavedTexts[0]["english_title"];?>';
        let savedName2 = '<?=$mostSavedTexts[1]["english_title"];?>';
        let savedName3 = '<?=$mostSavedTexts[2]["english_title"];?>';

        let savedValue1 = '<?=$mostSavedTexts[0]["total"];?>';
        let savedValue2 = '<?=$mostSavedTexts[1]["total"];?>';
        let savedValue3 = '<?=$mostSavedTexts[2]["total"];?>';
    </script>
    <script>
        /*info studied texts*/
        let studiedName1 = '<?=$mostStudiedTexts[0]["english_title"];?>';
        let studiedName2 = '<?=$mostStudiedTexts[1]["english_title"];?>';
        let studiedName3 = '<?=$mostStudiedTexts[2]["english_title"];?>';

        let studiedValue1 = '<?=$mostStudiedTexts[0]["total"];?>';;
        let studiedValue2 = '<?=$mostStudiedTexts[1]["total"];?>';;
        let studiedValue3 = '<?=$mostStudiedTexts[2]["total"];?>';;

    </script>
    <script>
        /*info how many of each type*/
        let american = <?=$howManyOfEachType['american'];?>;
        let british = <?=$howManyOfEachType['british'];?>;
    </script>
    <script src="<?=$base_url;?>/assets/js/admin/chart.js"></script>
@endsection