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

    public static function getNotifications($user_id, $maxNotPerUser){
        $notifications = Notification::
            join('users', 'users.id', '=', 'notifications.user_from')
            ->select('notifications.*', 'users.photo')
            ->where('user_to', $user_id)
            ->orderByDesc('date')
            ->limit($maxNotPerUser)
        ->get();

        return $notifications;
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

    public static function countAllCommentsAndSubComments($textid){
        $countComments = Comment::where('commented_text', $textid)->count();
        $countSubComments = Subcomment::where('textid', $textid)->count();

        return $countComments + $countSubComments;
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

    public static function getAllInteractions($ProfileUserId){
        $userInteractions = Interaction::
            where('user_id', $ProfileUserId)
            ->orderByDesc('interactions.last_update')
        ->get();

        return $userInteractions;
    }

    public static function getUserComments($ProfileUserId){
        $userComments = Comment::where('user_id', $ProfileUserId)->count();
        $userSubComments = Subcomment::where('user_id', $ProfileUserId)->count();
        return $userComments + $userSubComments;
    }

    public static function getTotalFollowers($ProfileUserId){
        $followers = Relation::where('to_user', $ProfileUserId)->count();
        return $followers;
    }

    public static function getTotalFollowing($ProfileUserId){
        $following = Relation::where('from_user', $ProfileUserId)->count();
        return $following;
    }

    public static function getPeopleFollowed($infoProfile, $user_id){
        $searchPeopleFollowed = Relation::
            where('from_user', $infoProfile['id'])
            ->join('users', 'users.id', '=', 'relations.to_user')
            ->select('user_name', 'photo', 'level', 'users.id')
        ->get();

        return $searchPeopleFollowed;
    }

    public static function getFollowers($infoProfile, $user_id){
        $searchFollowers = Relation::
            where('to_user', $infoProfile['id'])
            ->join('users', 'users.id', '=', 'relations.from_user')
            ->select('user_name', 'photo', 'level', 'users.id')
        ->get();

        return $searchFollowers;
    }

    public static function getTrophies($ProfileUserId){
        $trophies = Trophie::where('user_id', $ProfileUserId)->get();
        return $trophies;
    }

    public static function userFollowsThisPerson($ProfileUserId, $loggedUser){
        $getRelation = Relation::
            where('from_user', $loggedUser)
            ->where('to_user', $ProfileUserId)
        ->get();

        if(count($getRelation) > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function userStudiedThisText($textid, $user_id){
        $alreadyStudied = Studied_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->get();
        
        if(count($alreadyStudied) > 0){
            return true;
        }
        return false;
    }

    public static function userSavedThisText($textid, $user_id){
        $alreadySaved = Saved_text::
            where('user_id', $user_id)
            ->where('textid', $textid)
        ->get();
        
        if(count($alreadySaved) > 0){
            return true;
        }
        return false;
    }

    public static function getAllTextsStudies($user_id){
        $texts = Studied_text::
            where('user_id', $user_id)
            ->join('texts', 'studied_texts.textid', '=', 'texts.id')
            ->select('textid', 'image', 'english_title', 'level')
            ->orderByDesc('studied_texts.date')
        ->get();

        return $texts;
    }

    public static function getAllTextsSaved($user_id){
        $texts = Saved_text::
            where('user_id', $user_id)
            ->join('texts', 'saved_texts.textid', '=', 'texts.id')
            ->select('textid', 'image', 'english_title', 'level')
            ->orderByDesc('saved_texts.date')
        ->get();

        return $texts;
    }

    public static function getAssistentRecomendation($user, $english_type){
        
        $userSkills = $user['points'];

        switch($user['level']){
            case 'A1':
                $userSkills = 0;
                break;
            case 'A2':
                $userSkills = $userSkills + 3000;
                break;
            case 'B1':
                $userSkills = $userSkills + 15000;
                break;
            case 'B2':
                $userSkills = $userSkills + 90000;
                break;
            case 'C1':
                $userSkills = $userSkills + 200000;
                break;
            case 'C2':
                $userSkills = $userSkills + 500000;
                break;
        }
        
        if($userSkills >= 0 && $userSkills < 3000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,0)
                ->where('levels_points', '<' ,70)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,0)
                ->where('levels_points', '<' ,70)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 3000 && $userSkills < 15000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')    
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,70)
                ->where('levels_points', '<' ,100)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,70)
                ->where('levels_points', '<' ,100)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 15000 && $userSkills < 90000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,100)
                ->where('levels_points', '<' ,1500)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,100)
                ->where('levels_points', '<' ,1500)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 90000 && $userSkills < 200000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,1500)
                ->where('levels_points', '<' ,3000)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')    
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,1500)
                ->where('levels_points', '<' ,3000)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 200000 && $userSkills < 500000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,3000)
                ->where('levels_points', '<' ,10000)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')    
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,3000)
                ->where('levels_points', '<' ,10000)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 500000){

            $appropriateAmericanTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'americano')
                ->where('levels_points', '>=' ,10000)
                ->inRandomOrder()
            ->first();

            $appropriateBritishTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('type_english', 'britanico')
                ->where('levels_points', '>=' ,10000)
                ->inRandomOrder()
            ->first();

        }

        if($english_type == 'american'){
            return $appropriateAmericanTexts;
        }
        if($english_type == 'british'){
            return $appropriateBritishTexts;
        }
        echo "|ERROR| O tipo de inglês enviado não esta disponivel.";
        exit;
    }
    
}
