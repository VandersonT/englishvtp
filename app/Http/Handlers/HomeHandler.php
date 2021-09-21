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
use App\Models\Support_comment;
use App\Models\Daily_access;
use App\Models\User_on;
use App\Models\System;
use App\Models\Banned;
use App\Models\Exile;
use App\Models\UserNotification;
/*-----------------------------------------------------------------------------*/

class HomeHandler{

    public static function checkBan($loggedUserId){

        $data = Banned::
            where('user_id', $loggedUserId)
            ->join('users', 'users.id', '=', 'banned.responsible')
            ->select('banned.*', 'users.user_name')
        ->first();

        if(empty($data)){
            return false;
        }

        if($data['time'] < time() && $data['time'] != 'eterno'){
            $removeBan = Banned::
                where('user_id', $loggedUserId)
            ->delete();
            return false;
        }

        return $data;
    }

    public static function checkExile($loggedUserId){

        $data = Exile::
            where('user_id', $loggedUserId)
            ->join('users', 'users.id', '=', 'exile.responsible')
            ->select('exile.*', 'users.user_name')
        ->first();

        if(empty($data)){
            return false;
        }

        if($data['time'] < time() && $data['time'] != "eterno"){
            $removeExile = Exile::
                where('user_id', $loggedUserId)
            ->delete();
            return false;
        }

        return $data;
    }

    public static function getSystemStatus($search){
        $systemStatus = System::select($search)->first();
        return $systemStatus[$search];
    }

    public static function getThisUserNotification($loggedUserId){
        $notification = UserNotification::
            where(function($query) use ($loggedUserId){
                $query->where('user_to', $loggedUserId)
                ->orWhere('user_to', 0);
            })
        ->get();

        return $notification;
    }

    public static function getAllTextWithFilter($filter){

        $data = Text::
                where(function($query) use ($filter){
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
            ->select('texts.id', 'english_title', 'image', 'texts.level', 'user_name', 'last_update')
            ->where(function($query) use ($filter){
                $query->where('texts.level', $filter['levels'][0])
                ->orWhere('texts.level', $filter['levels'][1])
                ->orWhere('texts.level', $filter['levels'][2])
                ->orWhere('texts.level', $filter['levels'][3]);
            })
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('last_update')
        ->get();

        foreach($dataTexts as $dataText){
            $texts[] = array (
                'id' => $dataText['id'],
                'title' => $dataText['english_title'],
                'image' => $dataText['image'],
                'level' => $dataText['level'],
                'creator' => $dataText['user_name'],
                'last_update' => date('d/m/Y H:i', $dataText['last_update'])
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
                "last_update" => $data['last_update'],
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

    public static function getAllInteractions($ProfileUserId, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $userInteractions = Interaction::
            where('user_id', $ProfileUserId)
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('interactions.last_update')
        ->get();

        return $userInteractions;
    }

    public static function getTotalInteractions($ProfileUserId){
        $total = Interaction::
            where('user_id', $ProfileUserId)
        ->count();

        return $total;
    }

    public static function getTotalSupports($loggedUserId){
        $total = Support::
            where('user_id', $loggedUserId)
        ->count();

        return $total;
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

    public static function getPeopleFollowed($infoProfile, $user_id, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $searchPeopleFollowed = Relation::
            where('from_user', $infoProfile['id'])
            ->join('users', 'users.id', '=', 'relations.to_user')
            ->select('user_name', 'photo', 'level', 'users.id')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        return $searchPeopleFollowed;
    }

    public static function getFollowers($infoProfile, $user_id, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $searchFollowers = Relation::
            where('to_user', $infoProfile['id'])
            ->join('users', 'users.id', '=', 'relations.from_user')
            ->select('user_name', 'photo', 'level', 'users.id')
            ->offset($offset)
            ->limit($perPage)
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

    public static function getTotalStudiedText($loggedUserId){
        $total = Studied_text::where('user_id', $loggedUserId)->count();

        return $total;
    }

    public static function getAllTextsStudies($user_id, $page, $perPage){
        
        $offset = ($page - 1) * $perPage;
        
        $texts = Studied_text::
            where('user_id', $user_id)
            ->join('texts', 'studied_texts.textid', '=', 'texts.id')
            ->select('textid', 'image', 'english_title', 'level')
            ->offset($offset)
            ->limit($perPage)
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

    public static function getAssistentRecomendation($user){
        
        $userSkills = $user['points'];

        switch($user['level']){
            case 'A1':
                $userSkills = $userSkills + 0;
                break;
            case 'A2':
                $userSkills = $userSkills + 5000;
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
        
        if($userSkills >= 0 && $userSkills < 5000){

            $appropriateTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,0)
                ->where('levels_points', '<' ,70)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 5000 && $userSkills < 15000){

            $appropriateTexts = Text::
                select('id', 'english_title')    
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,70)
                ->where('levels_points', '<' ,100)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 15000 && $userSkills < 90000){

            $appropriateTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,100)
                ->where('levels_points', '<' ,1500)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 90000 && $userSkills < 200000){

            $appropriateTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,1500)
                ->where('levels_points', '<' ,3000)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 200000 && $userSkills < 500000){

            $appropriateTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,3000)
                ->where('levels_points', '<' ,10000)
                ->inRandomOrder()
            ->first();

        }else if($userSkills >= 500000){

            $appropriateTexts = Text::
                select('id', 'english_title')
                ->whereNotIn('id', Studied_Text::select('textid')->where('user_id', $user['id'])->get())
                ->where('levels_points', '>=' ,10000)
                ->inRandomOrder()
            ->first();

        }

        return $appropriateTexts;
        exit;
    }

    public static function getMySupports($user_id, $page, $perPage){
        
        $offset = ($page - 1) * $perPage;

        $supports = Support::
            where('user_id', $user_id)
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('date')
        ->get();

        return $supports;
    }

    public static function getSupportSingle($support_id, $user_id){
        $support = Support::
            where('id', $support_id)
            ->where('user_id', $user_id)
        ->first();

        if($support){
            return $support;
        }

        return false;
    }

    public static function getTotalReplysSupport($user_id, $support_id){
        $total = Support_comment::
            where('user_id', $user_id)
            ->where('support_id', $support_id)
        ->count();

        return $total;
    }

    public static function getSupportReplys($idSupport, $page, $perPage){
        
        $offset = ($page - 1) * $perPage;

        $replys = Support_comment::
            join('users', 'users.id', '=', 'support_comments.user_id')
            ->where('support_id', $idSupport)
            ->select('support_comments.*', 'users.id', 'photo', 'user_name')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        return $replys;
    }

    public static function sendAccessToDb(){
        $info = Daily_access::first();
        
        $newAccess = Daily_access::find($info['id']);
            $newAccess->access = $info['access'] + 1;
        $newAccess->save();
    }

    public static function updateLastAction($user_id){
        $data = User_on::where('user_id', $user_id)->get();
        
        if(count($data) > 0){
            $updateAction = User_on::
                where('user_id', $user_id)
            ->update([
                'last_action' => time(),
                'status' => 'online'
            ]);
        }else{
            $addAction = new User_on;
                $addAction->user_id = $user_id;
                $addAction->last_action = time();
            $addAction->save();
        }

    }

}
