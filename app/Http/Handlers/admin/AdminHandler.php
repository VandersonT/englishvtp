<?php

namespace App\Http\Handlers\admin;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\Text;
use App\Models\Saved_text;
/*-----------------------------------------------------------------------------*/

class AdminHandler{

    public static function getMostSavedTexts(){
       $texts = Saved_text::
            join('texts', 'texts.id', '=', 'saved_texts.textid')
            ->select('english_title', 'textid', \DB::raw("count(saved_texts.id)"))
            ->orderByDesc(\DB::raw("count(saved_texts.id)"))
            ->groupBy('textid')
            ->limit(4)
        ->get();

        return $texts;
    }
    
}
