@extends('admin/layouts.struct')

<!--Page title-->
@section('title')
   EnglishVtp - banir 
@endsection


<!--Links-->
@section('links')
    <link rel="stylesheet" href="<?=$base_url;?>/assets/css/admin/banAction.css"  />
@endsection

<!--Content-->
@section('content')
    
    <h1 class="title">
        <i class="fas fa-ban"></i>
        Banir usuário
    </h1>

    <form class="formBan" method="POST">
        <label>Digite o id do usuário:</label>
        <input class="getId" type="number" name="idToBan" placeholder="Id" />
        
        <label>Digite o motivo:</label>
        <textarea></textarea>
        
        <label>Digite quanto tempo:</label>
        <div>
            <input class="getId time" type="number" name="time" />
            <select class="formTime" name="formTime">
                <option>Hora</option>
                <option>Dia</option>
                <option>Mês</option>
                <option>Ano</option>
            </select>
        </div>

        <button>Banir</button>
    </form>

@endsection

<!--Scripts-->
@section('scripts')
    <script>
        let btnTime = document.querySelector('.time');
        let options = document.querySelectorAll('.formTime option');

        btnTime.addEventListener('keyup', function(){
            if(btnTime.value > 1){
                options[0].innerHTML = 'Horas';
                options[1].innerHTML = 'Dias';
                options[2].innerHTML = 'Mêses';
                options[3].innerHTML = 'Anos';
            }else{
                options[0].innerHTML = 'Hora';
                options[1].innerHTML = 'Dia';
                options[2].innerHTML = 'Mês';
                options[3].innerHTML = 'Ano';
            }
        })

    </script>
@endsection