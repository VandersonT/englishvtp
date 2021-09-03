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
            select('textid', \DB::raw("count(id)"))
            ->orderByDesc(\DB::raw("count(id)"))
            ->groupBy('textid')
            ->limit(5)
        ->get();

       return $texts;
    }
    
}
