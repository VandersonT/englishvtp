<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Text;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Daily_access;
use App\Models\User_on;
use App\Models\System;
use App\Models\Banned;
use App\Models\Exile;
use App\Models\Report;
use App\Models\Support;
use App\Models\Support_comment;
use App\Models\Comment;
use App\Models\Subcomment;
use App\Models\UserNotification;
/*-----------------------------------------------------------------------------*/

class AdminHandler{

    public static function getInfoPageInitial(){
        $data = Initial::first();
        return $data;
    }

    public static function getMostSavedTexts(){
        $data = Saved_text::groupBy('textid')
            ->join('texts', 'texts.id', '=', 'saved_texts.textid')
            ->selectRaw('count(*) as total, textid, english_title')
            ->orderByDesc('total')
            ->limit(3)
        ->get();

        return $data;
    }

    public static function getMostStudiedTexts(){
        $data = Studied_text::groupBy('textid')
            ->join('texts', 'texts.id', '=', 'studied_texts.textid')
            ->selectRaw('count(*) as total, textid, english_title')
            ->orderByDesc('total')
            ->limit(3)
        ->get();

        return $data;
    }

    public static function getHowManyOfEachType(){
        $american = Text::where('type_english', 'americano')->count();
        $British = Text::where('type_english', 'britanico')->count();

        $array['american'] =  $american;
        $array['british'] =  $British;

        return $array;
    }

    public static function getTotalAccess(){
        $data = Daily_access::count();
        return $data;
    }

    public static function getTotalTexts(){
        $data = Text::count();
        return $data;
    }

    public static function getTotalAccounts(){
        $data = User::count();
        return $data;
    }

    public static function getUsersOn(){
        $supposedMembersOn = User_on::get();

        foreach($supposedMembersOn as $supposedMemberOn){
            if($supposedMemberOn['last_action'] + 600 < time()){
                $supposedMemberOn = User_on::
                    where('id', $supposedMemberOn['id'])
                ->update(['status' => 'offline']);
                //mais de 10 minutos, ou seja, não esta mais online
            }
        }

        $membersOn = User_on::
            where('status', 'online')
            ->join('users', 'users.id', '=', 'user_on.user_id')
            ->select('user_on.*', 'users.user_name')
        ->get();

        return $membersOn;
    }

    public static function getSystemInfo(){
        $systemInfo = System::first();
        return $systemInfo;
    }

    public static function getGlobalNotification(){
        $globalNotifications = UserNotification::
            where('user_to', 0)
        ->get();

        foreach($globalNotifications as $globalNotification){
            $data = User::
                join('userNotifications', 'users.id', 'userNotifications.staff_id')
                ->select('users.user_name')
            ->first();
            $globalNotification['responsible_name'] = $data['user_name'];
        }
        
        return $globalNotifications;
    }

    public static function getAllUsersNotification(){
        $allNotifications = UserNotification::
            join('users', 'users.id', '=' ,'userNotifications.user_to')
            ->select('userNotifications.*', 'users.user_name', 'users.photo')
        ->get();

        foreach($allNotifications as $allNotification){
            $data = User::
                join('userNotifications', 'users.id', 'userNotifications.staff_id')
                ->select('users.user_name')
            ->first();
            $allNotification['responsible_name'] = $data['user_name'];
        }

        return $allNotifications;
    }

    public static function getWantedUserNotification($wantedUser){

        if(is_numeric($wantedUser)){
            $allNotifications = UserNotification::
                join('users', 'users.id', '=' ,'userNotifications.user_to')
                ->select('userNotifications.*', 'users.user_name', 'users.photo')
                ->where('users.id', $wantedUser)
            ->get();
            
            foreach($allNotifications as $allNotification){
                $data = User::
                    join('userNotifications', 'users.id', 'userNotifications.staff_id')
                    ->select('users.user_name')
                ->first();
                $allNotification['responsible_name'] = $data['user_name'];
            }

            return $allNotifications;
        }

        $allNotifications = UserNotification::
            join('users', 'users.id', '=' ,'userNotifications.user_to')
            ->select('userNotifications.*', 'users.user_name', 'users.photo')
            ->where('users.user_name', 'like', $wantedUser.'%')
        ->get();
        
        foreach($allNotifications as $allNotification){
            $data = User::
                join('userNotifications', 'users.id', 'userNotifications.staff_id')
                ->select('users.user_name')
            ->first();
            $allNotification['responsible_name'] = $data['user_name'];
        }

        return $allNotifications;
    }

    public static function getInfoProfile($idProfile){
        $infoProfile = User::
            select('id', 'user_name', 'photo', 'email', 'level', 'access')
            ->where('id', $idProfile)
        ->first();

        if($infoProfile){
            return $infoProfile;
        }

    }

    public static function getTotalUsers(){
        $total = User::count();
        return $total;
    }

    public static function getTotalUsersWanted($wantedUser){
        $total = User::
            where('user_name', 'like', $wantedUser.'%')
        ->count();
        return $total;
    }

    public static function getAllUsers($page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = User::
            offset($offset)
            ->limit($perPage)
        ->get();

        return $users;
    }

    public static function getWantedUser($wantedUser, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = User::
            where('user_name', 'like', $wantedUser.'%')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        return $users;
    }

    public static function getTotalStaffs(){
        $total = User::
            where('access', '>', 1)
        ->count();
        return $total;
    }

    public static function getTotalStaffsWanted($wantedUser){
        $total = User::
            where('user_name', 'like', $wantedUser.'%')
            ->where('access', '>', 1)
        ->count();
        return $total;
    }

    public static function getAllStaffs($page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = User::
            where('access', '>', 1)
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('access')
        ->get();

        return $users;
    }

    public static function getWantedStaff($wantedUser, $page, $perPage){
        
        $offset = ($page - 1) * $perPage;

        $users = User::
            where('user_name', 'like', $wantedUser.'%')
            ->where('access', '>', 1)
            ->offset($offset)
            ->limit($perPage)
            ->orderByDesc('access')
        ->get();

        return $users;
    }

    public static function getWantedUserSingle($idSearch){
        $user = User::
            where('id', $idSearch)
            ->select('id', 'user_name', 'photo', 'email' ,'access', 'level')
        ->first();
        
        return $user;
    }

    public static function getTotalUserBan(){
        $total = Banned::count();
        return $total;
    }

    public static function getTotalUserBanWanted($wantedUser){
        $total = Banned::
            join('users', 'users.id', 'banned.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
        ->count();
        return $total;
    }

    public static function getAllUserBan($page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = Banned::
            join('users', 'users.id', 'banned.user_id')
            ->select('banned.*', 'users.user_name')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        foreach($users as $user){
            $data = User::
                join('banned', 'users.id', 'banned.responsible')
                ->select('users.user_name')
            ->first();
            $user['responsible_name'] = $data['user_name'];
        }

        return $users;
    }

    public static function getWantedUserBan($wantedUser, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = Banned::
            join('users', 'users.id', '=', 'banned.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
            ->select('banned.*', 'users.user_name')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        foreach($users as $user){
            $data = User::
                join('banned', 'users.id', 'banned.responsible')
                ->select('users.user_name')
            ->first();
            $user['responsible_name'] = $data['user_name'];
        }

        return $users;
    }

    public static function getTotalUserExiled(){
        $total = Exile::count();
        return $total;
    }

    public static function getTotalUserExiledWanted($wantedUser){
        $total = Exile::
            join('users', 'users.id', 'exile.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
        ->count();
        return $total;
    }

    public static function getAllUserExile($page, $perPage){

        $offset = ($page - 1) * $perPage;

        $users = Exile::
            join('users', 'users.id', 'exile.user_id')
            ->select('exile.*', 'users.user_name')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        foreach($users as $user){
            $data = User::
                join('exile', 'users.id', 'exile.responsible')
                ->select('users.user_name')
            ->first();
            $user['responsible_name'] = $data['user_name'];
        }

        return $users;
    }

    public static function getWantedUserExile($wantedUser, $page, $perPage){
        
        $offset = ($page - 1) * $perPage;

        $users = Exile::
            join('users', 'users.id', '=', 'exile.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
            ->select('exile.*', 'users.user_name')
            ->offset($offset)
            ->limit($perPage)
        ->get();

        foreach($users as $user){
            $data = User::
                join('exile', 'users.id', 'exile.responsible')
                ->select('users.user_name')
            ->first();
            $user['responsible_name'] = $data['user_name'];
        }

        return $users;
    }

    public static function getAllTexts(){
        $texts = Text::
            select('image', 'english_title', 'id')
        ->get();

        return $texts;
    }

    public static function getWantedText($wantedText){
        $texts = Text::
            where('english_title', 'like', '%'.$wantedText.'%')
            ->select('image', 'english_title', 'id')
        ->get();

        return $texts;
    }

    public static function getText($TextId){
        $texts = Text::
            where('id', $TextId)
        ->first();

        return $texts;
    }

    public static function getAllReports($status, $page, $perPage){

        $offset = ($page - 1) * $perPage;

        $reports = Report::
            join('users', 'users.id', '=', 'reports.user_id')
            ->select('reports.*', 'users.user_name')
            ->where('status', $status)
            ->offset($offset)
            ->limit($perPage)
        ->get();

        return $reports;
    }

    public static function getTotalReportsType($type){
        $reports = Report::
            where('status', $type)
        ->count();
        return $reports;
    }

    public static function getReport($idReport, $type){
        
        if($type == 'comment'){
            $report = Report::
                join('comments', 'comments.id', '=', 'reports.comment_id')
                ->where('reports.id', $idReport)
                ->select('reports.id','reports.type', 'reports.status', 'comments.comment', 'comments.user_id', 'comments.last_update')
            ->first();
        }else{
            $report = Report::
                join('subcomments', 'subcomments.id', '=', 'reports.comment_id')
                ->where('reports.id', $idReport)
                ->select('reports.id','reports.type', 'reports.status', 'subcomments.comment', 'subcomments.user_id', 'subcomments.last_update')
            ->first();
        }

        $data = User::
            where('id', '=', $report['user_id'])
        ->first();
        $report['reported_id'] = $data['id'];
        $report['reported_name'] = $data['user_name'];
        $report['reported_photo'] = $data['photo'];

        return $report;
    }

    public static function getAllSupports($status){
        $supports = Support::
            join('users', 'users.id', '=', 'supports.user_id')
            ->select('supports.*', 'users.user_name')
            ->where('status', $status)
        ->get();

        return $supports;
    }

    public static function getSupport($supportId){
        $support = Support::
            join('users', 'users.id', '=', 'supports.user_id')
            ->select('supports.*', 'users.user_name', 'users.photo')
            ->where('supports.id', $supportId)
        ->first();

        return $support;
    }

    public static function getSupportReplys($supportId){
        $supportReplys = Support_comment::
            join('users', 'users.id', '=', 'support_comments.user_id')
            ->select('support_comments.*', 'users.user_name', 'users.photo')
            ->where('support_id', $supportId)
        ->get();

        return $supportReplys;
    }

}
