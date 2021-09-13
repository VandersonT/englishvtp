@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglisVtp - reportes pendentes
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/reports.css" />
@endsection

<!--Content-->
@section('content')

    <div class="note resolvedColor">
        <h1><i class="far fa-sticky-note"></i>Sobre os resolvidos:</h1>
        <p>Aqui ficam os reportes que já foram resolvidos por algum membro da staff antes, se você possui o cargo de moderador ou superior, pode revisa-los e até mesmo mudar o status.</p>
    </div>

    <h1 class="title">
        <i class="fas fa-users"></i>
        Reportes Resolvidos
    </h1>

    <table>
        <tr>
            <th>
                Id
            </th>
            <th>
                reportado por
            </th>
            <th>
                Status
            </th>
            <th>
                Ações
            </th>
        </tr>
        <?php if(count($reports) > 0):?>
            <?php foreach($reports as $report): ?>
                <tr>
                    <td>
                        <?=$report['id'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/perfil/<?=$report['user_id'];?>"><?=$report['user_name'];?></a>
                    </td>
                    <td>
                        <?=$report['status'];?>
                    </td>
                    <td>
                        <a href="<?=$base_url;?>/Painel/reporte/<?=$report['type'];?>/<?=$report['id'];?>" class="btn seeReports">
                            <?php if($user['access'] < 3): ?>
                                <i class="fas fa-lock"></i>
                            <?php endif; ?>
                            Abrir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php if(count($reports) < 1):?>
        <h1 class="empty">
            Não tem nenhum reporte resolvido ainda.
        </h1>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/reports.js"></script>
@endsection