<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\System;
use App\Models\Banned;
use App\Models\Exile;
use App\Models\Text;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Report;
use App\Models\Support;
use App\Models\UserNotification;
/*-----------------------------------------------------------------------------*/

class ActionAdminHandler{

    public static function changeSystemInfo($btn, $action){
        switch($btn){
            case 'system':
                $system = System::
                    where('id', 1)
                ->update(['system' => $action]);
                echo 'trocado sistema';
                break;
            case 'reports':
                $system = System::
                    where('id', 1)
                ->update(['reports' => $action]);
                echo 'trocado reportes';
                break;
            case 'comments':
                $system = System::
                    where('id', 1)
                ->update(['comments' => $action]);
                echo 'trocado comments';
                break;
            case 'support':
                $system = System::
                    where('id', 1)
                ->update(['support' => $action]);
                echo 'trocado suports';
                break;
        }
        echo 'fechou';
    }

    public static function getUserAccess($userSearch){
        $user = User::where('id', $userSearch)->first();

        return $user['access'];
    }
    
    public static function sendNotification($user_to,$color,$title,$content,$loggedUserId){
        
        $user = User::where('id', $user_to)->count();
        
        if(!$user){
            return 'O ID informado não esta atribuido a nenhuma conta registrada.';
        }

        $data = UserNotification::
            where('user_to', $user_to)
            ->orWhere('user_to', 0)
            ->where('viewed', 0)
        ->count();
        
        if($data >= 3){
            return 'Contando com as notificações globais, este usuário já possui 3 notificações ainda não vistas, para impedir span, esta ultima notificação não foi enviada, se mesmo assim quiser envia-la, gerencie as notificações deste usuário e exclua alguma das que foram enviadas anteriormente.';
        }

        $newNot = new UserNotification;
            $newNot->staff_id = $loggedUserId;
            $newNot->user_to = $user_to;
            $newNot->title = $title;
            $newNot->message = $content;
            $newNot->last_update = time();
            $newNot->color = $color;
            $newNot->viewed = false;
        $newNot->save();

        return false;//there is no error
    }

    public static function deleteNotification($notificationId){
        $unBan = UserNotification::
            where('id', $notificationId)
        ->delete();
    }

    public static function changeUserAccess($userToChange, $newAccess){
       
        $data = User::where('id', $userToChange)->first();

        $position = '';
        if($newAccess == 1){
            $position = 'usuário';
        }
        if($newAccess == 2){
            $position = 'ajudante'; 
        }
        if($newAccess == 3){
            $position = 'moderador';
        }
        if($newAccess == 4){
            $position = 'administrador';
        }
        if($newAccess == 5){
            $position = 'dono';
        }

        $user = User::
            where('id', $userToChange)
        ->update(['access' => $newAccess]);

        if($newAccess < $data['access']){
            $flash = 'Você rebaixou o usuário '.$data['user_name'].' para o cargo de '.$position.' do sistema.';
            return $flash;
        }

        $flash = 'Você promoveu o usuário '.$data['user_name'].' para o cargo de '.$position.' do sistema.';
        return $flash;
    }

    public static function banAction($idToBan, $reason, $formTime, $time, $idResponsible){

        $userToBan = User::where('id', $idToBan)->first();

        if(!$userToBan){
            return false;
        }

        if($formTime == 'Hora' || $formTime == 'Horas'){
            $time = strtotime("+".$time." hours");
        }else if($formTime == 'Dia' || $formTime == 'Dias'){
            $time = strtotime("+".$time." day");
        }else if($formTime == 'Mês' || $formTime == 'Meses'){
            $time = strtotime("+".$time." month");
        }else if($formTime == 'Ano' || $formTime == 'Anos'){
            $time = strtotime("+".$time." year");
        }else if($formTime == 'Eterno'){
            $time = 'eterno';
        }else{
            return false;
        }

        $ban = new Banned;
            $ban->user_id = $idToBan;
            $ban->responsible = $idResponsible;
            $ban->time = $time;
            $ban->reason = $reason;
        $ban->save();

        return true;
    }

    public static function unBanUser($userToUnBan){
        $unBan = Banned::
            where('user_id', $userToUnBan)
        ->delete();
    }

    public static function exileAction($idToExile, $reason, $formTime, $time, $idResponsible){

        $userToBan = User::where('id', $idToExile)->first();

        if(!$userToBan){
            return false;
        }

        if($formTime == 'Hora' || $formTime == 'Horas'){
            $time = strtotime("+".$time." hours");
        }else if($formTime == 'Dia' || $formTime == 'Dias'){
            $time = strtotime("+".$time." day");
        }else if($formTime == 'Mês' || $formTime == 'Meses'){
            $time = strtotime("+".$time." month");
        }else if($formTime == 'Ano' || $formTime == 'Anos'){
            $time = strtotime("+".$time." year");
        }else if($formTime == 'Eterno'){
            $time = 'eterno';
        }else{
            return false;
        }

        $exile = new Exile;
            $exile->user_id = $idToExile;
            $exile->responsible = $idResponsible;
            $exile->time = $time;
            $exile->reason = $reason;
        $exile->save();

        return true;
    }

    public static function repatriateUser($userToRepatriate){
        $repatriate = Exile::
            where('user_id', $userToRepatriate)
        ->delete();
    }

    public static function saveNewText($englishLevel,$points,$englishType,$englishTitle,$englishContent,$portugueseTitle,$portugueseContent,$nameAudio,$nameImage,$loggedUserId){
        
        $newText = new Text;
            $newText->type_english = $englishType;
            $newText->image = $nameImage;
            $newText->level = $englishLevel;
            $newText->levels_points = $points;
            $newText->english_title = $englishTitle;
            $newText->english_content = $englishContent;
            $newText->translated_title = $portugueseTitle;
            $newText->translated_content = $portugueseContent;
            $newText->created = time();
            $newText->created_by_id = $loggedUserId;
            $newText->last_update = time();
            $newText->updated_by_id = $loggedUserId;
            $newText->audio = $nameAudio;
        $newText->save();
    }

    public static function deleteText($textId){
        $delText = Text::
            where('id', $textId)
        ->delete();

        $delSavedText = Saved_text::
            where('textid', $textId)
        ->delete();

        $delStudiedText = Studied_text::
            where('textid', $textId)
        ->delete();
    }

    public static function editText($englishLevel,$points,$englishType,$englishTitle,$englishContent,$portugueseTitle,$portugueseContent,$nameAudio,$nameImage,$loggedUserId,$audioUpdated,$imageUpdated,$textToUpdate){
        $editText = Text::find($textToUpdate);
            $editText->type_english = $englishType;
            $editText->level = $englishLevel;
            $editText->levels_points = $points;
            $editText->english_title = $englishTitle;
            $editText->english_content = $englishContent;
            $editText->translated_title = $portugueseTitle;
            $editText->translated_content = $portugueseContent;
            $editText->created = time();
            $editText->created_by_id = $loggedUserId;
            $editText->last_update = time();
            $editText->updated_by_id = $loggedUserId;
        $editText->save();

        if($audioUpdated){
            $editAudio = Text::find($textToUpdate);
                $editAudio->audio = $nameAudio;
            $editAudio->save();
        }

        if($imageUpdated){
            $editImage = Text::find($textToUpdate);
                $editImage->image = $nameImage;
            $editImage->save();
        }
        
    }

    public static function updateReport($reportId, $newStatus){
        $updateReportStatus = Report::find($reportId);
            $updateReportStatus->status = $newStatus;
        $updateReportStatus->save();
    }

    public static function updateSupport($supportId, $newStatus){
        $updateSupportStatus = Support::find($supportId);
            $updateSupportStatus->status = $newStatus;
        $updateSupportStatus->save();
    }

}
