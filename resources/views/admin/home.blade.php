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
    <h1 class="title">
        <i class="fas fa-chart-line"></i>
        Dashboard
    </h1>
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
                <p class="number"><?=count($usersOn);?></p>
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
                Textos mais Salvos
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
            <i class="fas fa-globe-europe"></i>
            Usuários Online
        </h1>

        <table class="boxUsers">
            <tr>
                <th>Id</th>
                <th>Usuário</th>
                <th>Último acesso</th>
            </tr>
            <?php if(count($usersOn) > 0): ?>
                <?php foreach ($usersOn as $userOn): ?>
                    <tr>
                        <td><?=$userOn['user_id'];?></td>
                        <td><?=$userOn['user_name'];?></td>
                        <td><?=date('H:i', $userOn['last_action']);?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty">
                    <td>0</td>
                    <td>Não tem nenhum usuário online no momento</td>
                    <td>0</td>
                </tr>
            <?php endif; ?>
        </table>

    </section>

    <section class="guide">
        <h1 class="title">
            <i class="fab fa-guilded"></i>
            Cargos do Painel
        </h1>
        <h4><i class="fas fa-chart-line"></i>Ajudante:</h4>
        <p>O ajudante é responsavel por controlar e manter a ordem no sistema principal e auxiliar os usuários, ele tem permissão para apagar qualquer comentário que quiser, desde que aja um motivo justo. O ajudante também tem acesso a página de suportes, podendo auxliar os usuários por lá, também podendo bloquear o envio de novos suportes.</p>

        <h4><i class="far fa-file-alt"></i>Moderador:</h4>
        <p>O moderador possui os mesmo controles que os ajudantes, mas ele vai além, podendo exilar e tirar do exilio um usuário. O moderador também pode bloquear/desbloquear os comentários e reportes</p>

        <h4><i class="far fa-user"></i>Administrador:</h4>
        <p>Além de poder fazer tudo que moderador e ajudante faz, o administrador pode bloquear o sistema completamente, impedindo qualquer acesso. O administrador tem controle sobre os bans, podendo banir ou retirar ban de algum usuário. Ele pode gerenciar todos os cargos abaixo dele, podendo rebaixar ou promover.</p>

        <h4><i class="fas fa-align-left"></i>Dono:</h4>
        <p>O dono além de poder fazer tudo que os cargo abaixo fazem, ele tem o controle sobre todos os cargos do sistema e seu cargo não pode ser alterado nem por um administrador.</p>

    </section>

    <section class="box-controls">
        <h1 class="title">
            <i class="fas fa-gamepad"></i>
            Controles Principais
        </h1>
        
        <div class="box-btns">
            <a class="btnSingle system <?=($systemInfo['system']) ? 'on' : 'off';?>">
                Sistema: <?=($systemInfo['system']) ? 'On' : 'Off';?>
            </a>
            <a class="btnSingle reports <?=($systemInfo['reports']) ? 'on' : 'off';?>">
                Reportes: <?=($systemInfo['reports']) ? 'On' : 'Off';?>
            </a>
            <a class="btnSingle comments <?=($systemInfo['comments']) ? 'on' : 'off';?>">
                Comentários: <?=($systemInfo['comments']) ? 'On' : 'Off';?>
            </a>
            <a class="btnSingle support <?=($systemInfo['support']) ? 'on' : 'off';?>">
                Suporte: <?=($systemInfo['support']) ? 'On' : 'Off';?>
            </a>
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
    <script src="<?=$base_url;?>/assets/js/admin/home.js"></script>
@endsection