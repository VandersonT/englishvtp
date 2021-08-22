<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Text;
use App\Models\Comment;
use App\Models\Subcomment;
use App\Models\Comments_rating;
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
        /*$addRate = new Comments_rating;
            $addRate->user_id = $user_id;
            $addRate->id_comment = $idComment;
            $addRate->type = $commentType;
            $addRate->rate = $rate;
        $addRate->save();*/

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

}
