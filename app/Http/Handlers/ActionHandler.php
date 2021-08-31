<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Text;
use App\Models\Comment;
use App\Models\Subcomment;
use App\Models\Comments_rating;
use App\Models\Relation;
use App\Models\Trophie;
use App\Models\Interaction;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Notification;
use App\Models\Support;
use App\Models\Suport_comment;
/*-----------------------------------------------------------------------------*/

class ActionHandler{

    public static function sendNewComment($message, $textid, $user){
        $newComment = new Comment;
            $newComment->user_id = $user['id'];
            $newComment->comment = $message;
            $newComment->last_update = time();
            $newComment->commented_text	 = $textid;
        $newComment->save();

        $lastUserComment = Comment::where('user_id', $user['id'])
            ->orderBy('last_update', 'desc')
        ->first();

        $data = Text::where('id', $textid)->first();
        $nameText = $data['english_title'];

        $interaction = new Interaction;
            $interaction->user_id = $user['id'];
            $interaction->message = $user['name'].' comentou no texto "'.$nameText.'".';
            $interaction->whereOccurred = $_SERVER['HTTP_REFERER'];
            $interaction->last_update = time();
            $interaction->userWords = $message; //This is filled only when the user do a interation on its own*/
            $interaction->actionId = $lastUserComment['id'];
        $interaction->save();

    }

    public static function deleteComment($commentId){
        $commentToDelete = Comment::find($commentId);
        $commentToDelete->delete();

        $deleteSubsComments = Subcomment::
            where('comment_answered', $commentId)
        ->delete();

        $deleteInteration = Interaction::
            where('actionId', $commentId)
        ->delete();
    }

    public static function sendNewSubComment($commentId, $subComment, $textid, $user){
        $newComment = new Subcomment;
            $newComment->user_id = $user['id'];
            $newComment->comment = $subComment;
            $newComment->last_update = time();
            $newComment->comment_answered = $commentId;
            $newComment->textid	 = $textid;
        $newComment->save();

        $lastUserComment = Subcomment::where('user_id', $user['id'])
            ->orderBy('last_update', 'desc')
        ->first();
        

        $data = Text::where('id', $textid)->first();
        $nameText = $data['english_title'];
        
        $interaction = new Interaction;
            $interaction->user_id = $user['id'];
            $interaction->message = $user['name'].' respondeu um comentário no texto "'.$nameText.'".';
            $interaction->whereOccurred = $_SERVER['HTTP_REFERER'];
            $interaction->last_update = time();
            $interaction->userWords = $subComment; /*This is filled only when the user do a interation on its own*/
            $interaction->actionId = $lastUserComment['id'];
        $interaction->save();

    }

    public static function sendCommentNotification($loggedUser, $userToNot, $commentId, $textId){
        $notificationUsers = Subcomment::
            select('user_id')
            ->where('comment_answered', $commentId)
            ->distinct()
        ->get();

        /*Notifica o cara que fez o comentario principal se ele não for o usuário logado*/
        if($userToNot != $loggedUser['id']){
            $notification = new Notification;
                $notification->user_from = $loggedUser['id'];
                $notification->user_to = $userToNot;
                $notification->whereOcurred = $_SERVER['HTTP_REFERER'];
                $notification->message = $loggedUser['name'].' respondeu um comentário feito por você.';
                $notification->date = time();
            $notification->save();
        }
        /***/

        /*
        Notifica todos que comentaram o comentario respondido, desde que não seja o cara
        que acabou de comentar nem o dono do comentario, pois ele já foi notificado
        */
        foreach($notificationUsers as $notificationUser){
            if($notificationUser['user_id'] != $loggedUser['id'] && $notificationUser['user_id'] != $userToNot){
                $notification = new Notification;
                    $notification->user_from = $loggedUser['id'];
                    $notification->user_to = $notificationUser['user_id'];
                    $notification->whereOcurred = $_SERVER['HTTP_REFERER'];
                    $notification->message = $loggedUser['name'].' também comentou em um comentário que você esta seguindo.';
                    $notification->date = time();
                $notification->save();
            }
        }
        /***/
    }

    public static function deleteSubComment($subCommentId){
        $subCommentToDelete = Subcomment::find($subCommentId);
        $subCommentToDelete->delete();

        $deleteInteration = Interaction::
            where('actionId', $subCommentId)
        ->delete();
    }

    public static function changeRelation($ProfileUserId, $loggedUser){
        $getRelation = Relation::
            where('from_user', $loggedUser)
            ->where('to_user', $ProfileUserId)
        ->get();

        if(count($getRelation) > 0){
            $following = Relation::
                where('from_user', $loggedUser)
                ->where('to_user', $ProfileUserId)
            ->delete();
        }else{
            $following = new Relation;
                $following->from_user = $loggedUser;
                $following->to_user = $ProfileUserId;
            $following->save();
        }

    }

    public static function sendFollowNotification($loggedUser, $profileUserId){
        $getRelation = Relation::
            where('from_user', $loggedUser['id'])
            ->where('to_user', $profileUserId)
        ->get();

        if(count($getRelation) > 0){
            $sendNotification = new Notification;
                $sendNotification->user_from = $loggedUser['id'];
                $sendNotification->user_to = $profileUserId;
                $sendNotification->whereOcurred = url('').'/perfil/'.$loggedUser['id'];
                $sendNotification->message = $loggedUser['name'].' começou a te seguir.';
                $sendNotification->date = time();
            $sendNotification->save();
        }else{
            $removeNotification = Notification::
                where('user_from', $loggedUser['id'])
                ->where('user_to', $profileUserId)
            ->delete();
        }
    }

    public static function getTextStudied($textid, $user_id){
        $data = Studied_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->get();

        if(count($data) > 0){
            return true;
        }

        return false;
    }

    public static function removeTextStudied($textid, $user_id){
        $studiedText = Studied_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->delete();
    }

    public static function addTextStudied($textid, $user_id){
        $studiedText = new Studied_text;
            $studiedText->user_id = $user_id;
            $studiedText->textid = $textid;
            $studiedText->date = time();
        $studiedText->save();
    }

    public static function getTextSaved($textid, $user_id){
        $data = Saved_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->get();

        if(count($data) > 0){
            return true;
        }

        return false;
    }

    public static function removeTextSaved($textid, $user_id){
        $studiedText = Saved_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->delete();
    }

    public static function addTextSaved($textid, $user_id){
        $studiedText = new Saved_text;
            $studiedText->user_id = $user_id;
            $studiedText->textid = $textid;
            $studiedText->date = time();
        $studiedText->save();
    }

    public static function getTextPoints($textid){
        $data = Text::
            where('id', $textid)
            ->select('levels_points')
        ->first();

        return $data['levels_points'];
    }

    public static function upLevelUser($user_id, $textPoints){
        $userInfo = User::find($user_id);
            $userInfo->points = $userInfo->points + $textPoints;
        $userInfo->save();
    }

    public static function downLevelUser($user_id, $textPoints){
        $userInfo = User::find($user_id);
            $userInfo->points = $userInfo->points - $textPoints;
        $userInfo->save();
    }

    public static function updateProfile($name, $email, $themeMode, $englishLevel, $profilePictureChanged, $namePhoto, $user_id){
        $userInfo = User::find($user_id);
            $userInfo->user_name = $name;
            $userInfo->email = $email;
            $userInfo->theme = $themeMode;
            $userInfo->level = $englishLevel;
        $userInfo->save();

        if($profilePictureChanged){
            $userInfo = User::find($user_id);
                $userInfo->photo = $namePhoto;
            $userInfo->save();
        }

    }

    public static function sendNewSupport($user_id, $title, $content){
        $newSupport = new Support;
            $newSupport->user_id = $user_id;
            $newSupport->title = $title;
            $newSupport->content = $content;
            $newSupport->date = time();
            $newSupport->status = 'pendente';
        $newSupport->save();
    }
    
}
