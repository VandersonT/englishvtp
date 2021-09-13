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
    
    <h1 class="title">
        <i class="fas fa-users"></i>
        Reportes Pendentes
    </h1>

    <div class="note">
        <h1><i class="far fa-sticky-note"></i> Nota:</h1>
        <p>Quando um usuário reporta algum comentário, significa que aquele comentário o incomodou de alguma forma e possivelmente possui desrespeito ou esta causando desordem, neste caso a staff deve analizar e aplicar a devida punição.</p>
    </div>

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
            Não tem nenhum reporte pendente
        </h1>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')
    <script src="<?=$base_url;?>/assets/js/admin/reports.js"></script>
@endsection