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
/*-----------------------------------------------------------------------------*/

class HomeHandler{

    public static function getAllTextWithFilter($filter){
        $data = Text::where('type_english', $filter['type'])
            ->where(function($query) use ($filter){
                $query->where('texts.level', $filter['levels'][0])
                ->orWhere('texts.level', $filter['levels'][1])
                ->orWhere('texts.level', $filter['levels'][2])
                ->orWhere('texts.level', $filter['levels'][3]);
            })
        ->get();

        return count($data);
    }

    public static function getTexts($filter, $page, $perPage){
        $texts = [];

        $offset = ($page - 1) * $perPage;

        $dataTexts = Text::join('users', 'users.id', '=', 'texts.created_by_id')
            ->select('texts.id', 'english_title', 'image', 'texts.level', 'user_name')
            ->where('type_english', $filter['type'])
            ->where(function($query) use ($filter){
                $query->where('texts.level', $filter['levels'][0])
                ->orWhere('texts.level', $filter['levels'][1])
                ->orWhere('texts.level', $filter['levels'][2])
                ->orWhere('texts.level', $filter['levels'][3]);
            })
            ->offset($offset)
            ->limit($perPage)
        ->get();

        foreach($dataTexts as $dataText){
            $texts[] = array (
                'id' => $dataText['id'],
                'title' => $dataText['english_title'],
                'image' => $dataText['image'],
                'level' => $dataText['level'],
                'creator' => $dataText['user_name']
            );
        }

        return $texts;

    }

    public static function getText($textid){
        $data = Text::where('id', $textid)->first();

        if($data){
            $creatorName = User::where('id', $data['created_by_id'])->get();

            if(count($creatorName) > 0){
                $creatorName = User::where('id', $data['created_by_id'])->first()->user_name;
            }else{
                $creatorName = 'Desconhecido';
            }

            $text = [
                "id" => $data['id'],
                "level" => $data['level'],
                "points" => $data['levels_points'],
                "englishTitle" => $data['english_title'],
                "englishContent" => $data['english_content'],
                "translatedTitle" => $data['translated_title'],
                "translatedContent" => $data['translated_content'],
                "created" => $data['created'],
                "creatorName" => $creatorName,
                "audio" => $data['audio'],
            ];

            return $text;
        }else{
            return false;
        }
    }

    public static function getTextComments($textid, $user, $page, $perPage){


        $offset = ($page - 1) * $perPage;

        $comments = Comment::join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'user_id', 'photo', 'comment', 'last_update', 'user_name')
            ->where('commented_text', $textid)
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('comments.id')
        ->get();

        foreach($comments as $comment){
            $likes = Comments_rating::
                where('id_comment', $comment['id'])
                ->where('type', 'normal')
                ->where('rate', 1)
            ->count();

            $unlikes = Comments_rating::
                where('id_comment', $comment['id'])
                ->where('type', 'normal')
                ->where('rate', -1)
            ->count();

            $userRated = Comments_rating::select('rate')
                ->where('user_id', $user['id'])
                ->where('id_comment', $comment['id'])
                ->where('type', 'normal')
            ->first();

            if($userRated){
                $userRated = $userRated['rate'];
            }else{
                $userRated = 0;
            }

            $subcomments = Subcomment::
                where('comment_answered', $comment['id'])
            ->count();

            $comment['userRated'] = $userRated;
            $comment['likes'] = $likes;
            $comment['unlikes'] = $unlikes;
            $comment['subcomments'] = $subcomments;
            
        }

        
        return $comments;
    }

    public static function getTextSubComments($textid, $user){

        $subcomments = Subcomment::join('users', 'users.id', '=', 'subcomments.user_id')
            ->select('subcomments.id', 'comment_answered', 'user_id', 'photo', 'comment', 'last_update', 'user_name')
            ->where('textid', $textid)
        ->get();

        foreach($subcomments as $subcomment){
            $likes = Comments_rating::
                where('id_comment', $subcomment['id'])
                ->where('type', 'sub')
                ->where('rate', 1)
            ->count();

            $unlikes = Comments_rating::
                where('id_comment', $subcomment['id'])
                ->where('type', 'sub')
                ->where('rate', -1)
            ->count();

            $userRated = Comments_rating::select('rate')
                ->where('user_id', $user['id'])
                ->where('id_comment', $subcomment['id'])
                ->where('type', 'sub')
            ->first();

            if($userRated){
                $userRated = $userRated['rate'];
            }else{
                $userRated = 0;
            }

            $subcomment['userRated'] = $userRated;
            $subcomment['likes'] = $likes;
            $subcomment['unlikes'] = $unlikes;
            
        }

        return $subcomments;
    }

    public static function countAllComments($textid){
        $countComments = Comment::where('commented_text', $textid)->count();

        return $countComments;
    }

    public static function sendNewComment($message, $textid, $user_id){
        $newComment = new Comment;
            $newComment->user_id = $user_id;
            $newComment->comment = $message;
            $newComment->last_update = time();
            $newComment->commented_text	 = $textid;
        $newComment->save();
    }

    public static function deleteComment($commentId){
        $commentToDelete = Comment::find($commentId);
        $commentToDelete->delete();

        $deleteSubsComments = Subcomment::
            where('comment_answered', $commentId)
        ->delete();
    }

    public static function sendNewSubComment($commentId, $subComment, $textId, $user_id){
        $newComment = new Subcomment;
            $newComment->user_id = $user_id;
            $newComment->comment = $subComment;
            $newComment->last_update = time();
            $newComment->comment_answered = $commentId;
            $newComment->textid	 = $textId;
        $newComment->save();
    }

    public static function deleteSubComment($subCommentId){
        $subCommentToDelete = Subcomment::find($subCommentId);
        $subCommentToDelete->delete();
    }

    public static function getInfoProfile($idProfile){
        $infoProfile = User::select('id', 'user_name', 'photo')
            ->where('id', $idProfile)
        ->first();

        if($infoProfile){
            return $infoProfile;
        }

        return false;
    }

    public static function getProfileUserComments($ProfileUserId){
        $comments = Comment::join('texts', 'comments.commented_text', '=', 'texts.id')
            ->select('english_title', 'commented_text', 'comments.id', 'comments.last_update', 'comments.comment')
            ->where('user_id', $ProfileUserId)
            ->orderByDesc('comments.last_update')
        ->get();

        return $comments;
    }

    public static function getFollowers($ProfileUserId){
        $followers = Relation::where('to_user', $ProfileUserId)->count();
        return $followers;
    }

    public static function getFollowing($ProfileUserId){
        $following = Relation::where('from_user', $ProfileUserId)->count();
        return $following;
    }

    public static function getTrophies($ProfileUserId){
        $trophies = Trophie::where('user_id', $ProfileUserId)->get();
        return $trophies;
    }
    
}
