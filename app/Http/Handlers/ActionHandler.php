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
    
}
