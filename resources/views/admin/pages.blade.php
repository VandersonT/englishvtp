@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
    Painel - Páginas
@endsection


<!--Links-->
@section('links')
    
<link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/pages.css" />
@endsection

<!--Content-->
@section('content')

    <div class="note">
        <h1><i class="far fa-sticky-note"></i>Aviso:</h1>
        <p>
            Esta página já tem a sua pré-definido, sendo assim a unica coisa que é permitido alterar é a tela inicial do sistema.
            <br/>Se acaso queira modificar as demais telas, a alteração só é possivel ser feita pelo dono do sistema, tendo em posse os codigos fontes de todo o sistema.
        </p>
    </div>

    <h1 class="title">
        <i class="fab fa-google-wallet"></i>
        Todas as páginas do sistema
    </h1>

    <table>
        <tr>
            <th>
                Página
            </th>
            <th>
                Descrição
            </th>
            <th>
                Ações
            </th>
        </tr>
        <tr>
            <td>
                Inicial
            </td>
            <td>
                Esta é a tela de apresentação do sistema, tela que vem antes da home e até mesmo da de login e cadastro.
            </td>
            <td>
                <a href="<?=$base_url;?>/Painel/editarTela/inicial" class="btn">Editar</a>
            </td>
        </tr>
    </table>
@endsection

<!--Scripts-->
@section('scripts')

@endsection