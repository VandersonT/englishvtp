<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\Text;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Daily_access;
use App\Models\User_on;
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
        ->get();

        return $membersOn;
     }
    
}
