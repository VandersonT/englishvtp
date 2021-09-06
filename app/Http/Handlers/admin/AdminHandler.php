<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\Text;
use App\Models\Saved_text;
use App\Models\Studied_text;
use App\Models\Daily_access;
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

     public static function getAccess(){
        $data = Daily_access::first();

        /*$cookie = date('d/m/Y', time());
        $hoje = date('d/m/Y', time());
        
        if($cookie == $hoje){
            echo 'é maior';
        }else{
            echo 'é menor';
        }*/
     }
    
}
