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
        Reportes Ignorados
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
                        <a class="btn">Abrir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php if(count($reports) < 1):?>
        <h1 class="empty">
            Não tem nenhum reporte ignorado ainda.
        </h1>
    <?php endif; ?>

@endsection

<!--Scripts-->
@section('scripts')

@endsection