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

class HomeHandler{
    
    public static function getAllText($filter){
        $data = Text::join('users', 'users.id', '=', 'texts.created_by_id')
            ->select('texts.id', 'english_title', 'image', 'texts.level', 'user_name')
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

    public static function getTextComments($textid, $user){
        $datas = Comment::join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'user_id', 'photo', 'comment', 'last_update', 'user_name')
            ->where('commented_text', $textid)
        ->get();

        $comment = [];

        foreach($datas as $commentSingle){
            $likes = Comments_rating::
                where('id_comment', $commentSingle['id'])
                ->where('type', 'normal')
                ->where('rate', 1)
            ->count();

            $unlikes = Comments_rating::
                where('id_comment', $commentSingle['id'])
                ->where('type', 'normal')
                ->where('rate', -1)
            ->count();

            $userRated = Comments_rating::select('rate')
                ->where('user_id', $user['id'])
                ->where('id_comment', $commentSingle['id'])
                ->where('type', 'normal')
            ->first();

            if($userRated){
                $userRated = $userRated['rate'];
            }else{
                $userRated = 0;
            }

            $subcomments = Subcomment::
                where('comment_answered', $commentSingle['id'])
            ->count();

            $comment[] = array(
                'id' => $commentSingle['id'],
                'user_id' => $commentSingle['user_id'],
                'photo' => $commentSingle['photo'],
                'comment' => $commentSingle['comment'],
                'last_update' => $commentSingle['last_update'],
                'user_name' => $commentSingle['user_name'],
                'likes' => $likes,
                'unlikes' => $unlikes,
                'subcomments' => $subcomments,
                'userRated' => $userRated
            );
        }

        return $comment;
    }

    public static function getTextSubComments($textid){
        $datas = Subcomment::join('users', 'users.id', '=', 'subcomments.user_id')
            ->select('subcomments.id', 'user_id', 'photo', 'comment', 'last_update', 'user_name')
            ->where('textid', $textid)
        ->get();


        $subcomment = [];

        foreach($datas as $subcommentSingle){
            $likes = Comments_rating::
                where('id_comment', $subcommentSingle['id'])
                ->where('type', 'sub')
                ->where('rate', 1)
            ->count();

            $unlikes = Comments_rating::
                where('id_comment', $subcommentSingle['id'])
                ->where('type', 'sub')
                ->where('rate', 0)
            ->count();

            $subcomment[] = array(
                'id' => $subcommentSingle['id'],
                'user_id' => $subcommentSingle['user_id'],
                'photo' => $subcommentSingle['photo'],
                'comment' => $subcommentSingle['comment'],
                'last_update' => $subcommentSingle['last_update'],
                'user_name' => $subcommentSingle['user_name'],
                'likes' => $likes,
                'unlikes' => $unlikes
            );
        }

        return $subcomment;
    }
    
}
