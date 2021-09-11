<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\Text;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Daily_access;
use App\Models\User_on;
use App\Models\System;
use App\Models\Banned;
use App\Models\Exile;
/*-----------------------------------------------------------------------------*/

class AdminHandler{

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

     public static function getInfoProfile($idProfile){
        $infoProfile = User::
            select('id', 'user_name', 'photo', 'email', 'level', 'access')
            ->where('id', $idProfile)
        ->first();

        if($infoProfile){
            return $infoProfile;
        }

     }

     public static function getAllUsers(){
        $users = User::get();

        return $users;
     }

     public static function getWantedUser($wantedUser){
        $users = User::
            where('user_name', 'like', $wantedUser.'%')
        ->get();

        return $users;
     }

     public static function getAllStaffs(){
        $users = User::
            where('access', '>', 1)
            ->orderByDesc('access')
        ->get();

        return $users;
     }

     public static function getWantedStaff($wantedUser){
        $users = User::
            where('user_name', 'like', $wantedUser.'%')
            ->where('access', '>', 1)
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

     public static function getAllUserBan(){
        $users = Banned::
            join('users', 'users.id', 'banned.user_id')
            ->select('banned.*', 'users.user_name')
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

     public static function getWantedUserBan($wantedUser){
        $users = Banned::
            join('users', 'users.id', '=', 'banned.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
            ->select('banned.*', 'users.user_name')
            ->orderByDesc('access')
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

     public static function getAllUserExile(){
        $users = Exile::
            join('users', 'users.id', 'exile.user_id')
            ->select('exile.*', 'users.user_name')
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

     public static function getWantedUserExile($wantedUser){
        $users = Exile::
            join('users', 'users.id', '=', 'exile.user_id')
            ->where('user_name', 'like', $wantedUser.'%')
            ->select('exile.*', 'users.user_name')
            ->orderByDesc('access')
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
    
}
