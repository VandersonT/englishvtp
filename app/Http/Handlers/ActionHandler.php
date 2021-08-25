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
/*-----------------------------------------------------------------------------*/

class ActionHandler{

    public static function sendNewComment($message, $textid, $user){
        $newComment = new Comment;
            $newComment->user_id = $user['id'];
            $newComment->comment = $message;
            $newComment->last_update = time();
            $newComment->commented_text	 = $textid;
        $newComment->save();

        $data = Text::where('id', $textid)->first();
        $nameText = $data['english_title'];

        $interaction = new Interaction;
            $interaction->user_id = $user['id'];
            $interaction->message = $user['name'].' comentou no texto "'.$nameText.'".';
            $interaction->whereOccurred = $_SERVER['HTTP_REFERER'];
            $interaction->last_update = time();
            $interaction->userWords = $message; /*This is filled only when the user do a interation on its own*/
        $interaction->save();

    }

    public static function deleteComment($commentId){
        $commentToDelete = Comment::find($commentId);
        $commentToDelete->delete();

        $deleteSubsComments = Subcomment::
            where('comment_answered', $commentId)
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

        $data = Text::where('id', $textid)->first();
        $nameText = $data['english_title'];
        
        $interaction = new Interaction;
            $interaction->user_id = $user['id'];
            $interaction->message = $user['name'].' respondeu um comentario no texto "'.$nameText.'".';
            $interaction->whereOccurred = $_SERVER['HTTP_REFERER'];
            $interaction->last_update = time();
            $interaction->userWords = $subComment; /*This is filled only when the user do a interation on its own*/
        $interaction->save();

    }

    public static function deleteSubComment($subCommentId){
        $subCommentToDelete = Subcomment::find($subCommentId);
        $subCommentToDelete->delete();
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
    
}
