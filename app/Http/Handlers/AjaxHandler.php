<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Text;
use App\Models\Comment;
use App\Models\Subcomment;
use App\Models\Comments_rating;
use App\Models\Notification;
/*-----------------------------------------------------------------------------*/

class AjaxHandler{
    
    public static function isRated($id, $rate, $type, $user_id){

        $userRate = Comments_rating::
            select('rate')
            ->where('user_id', $user_id)
            -> where('id_comment', $id)
            -> where('type', $type)
        ->first();

        if($userRate){
            $rate = $userRate['rate'];
            return $rate;
        }

        return false;
    }

    public static function deleteRated($idComment, $commentType, $user_id){
        $deleteRate = Comments_rating::
            where('id_comment', $idComment)
            ->where('user_id', $user_id)
            ->where('type', $commentType)
        ->delete();
    }

    public static function addRated($idComment, $commentType, $user_id, $rate){

        $addRate = Comments_rating::create([
            'user_id' => $user_id,
            'id_comment' => $idComment,
            'type' => $commentType,
            'rate' => $rate,
        ]);

    }

    public static function updateRated($idComment, $commentType, $user_id, $rate){
        $updateRate = Comments_rating::
            where('id_comment', $idComment)
            ->where('user_id', $user_id)
            ->where('type', $commentType)
        ->update(['rate' => $rate]);
    }

    public static function getUserToNotification($idComment, $commentType){
        echo 'id: '.$idComment;
        if($commentType == 'normal'){
            $userRate = Comment::
                select('user_id')
                ->where('id', $idComment)
            ->first();
            $userSearch = $userRate['user_id'];
            return $userSearch;

        }else{
            $userRate = Subcomment::
                select('user_id')
                ->where('id', $idComment)
            ->first();
            $userSearch = $userRate['user_id'];
            return $userSearch;
        }
    }

    public static function sendRatedNotification($loggedUser, $idComment, $rate, $userToNotification){

        $alreadyNotified = Notification::
            where('idAction', $idComment)
        ->first();

        if($alreadyNotified){
            $updateNotification = Notification::
                where('idAction', $idComment)
                ->where('user_from', $loggedUser['id'])
                ->where('user_to', $userToNotification)
            ->update([
                'message' => ($rate == 1) ? $loggedUser['user_name'].' curtiu um comentário feito por você.' : $loggedUser['user_name'].' não gostou de um comentário feito por você.',
                'date' => time()
            ]);
        }else{
            $addNotification = new Notification;
                $addNotification->user_from = $loggedUser['id'];
                $addNotification->user_to = $userToNotification;
                $addNotification->whereOcurred = $_SERVER['HTTP_REFERER'];
                $addNotification->message = ($rate == 1) ? $loggedUser['name']." curtiu um comentário feito por você." : $loggedUser['name']." não gostou de um comentário feito por você.";
                $addNotification->date = time();
                $addNotification->viewed = false;
                $addNotification->idAction = $idComment;
            $addNotification->save();
        }

    }

    public static function deleteRatedNotification($loggedUser, $idComment, $userToNotification){
        $deleteRate = Notification::
            where('idAction', $idComment)
            ->where('user_from', $loggedUser['id'])
            ->where('user_to', $userToNotification)
        ->delete();
    }

    public static function setNotificationToView($idNot){
        $deleteN = Notification::
            where('id', $idNot)
        ->delete();
    }

}
