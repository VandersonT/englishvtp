<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\Initial;
use App\Models\User;
use App\Models\Text;
/*-----------------------------------------------------------------------------*/

class HomeHandler{
    
    public static function getTexts($filter){
        $Texts = [];

        /*$dataTexts = Text::
            where('type_english', $filter['type'])
            ->orWhere('level', $filter['levels'][0])
            ->orWhere('level', $filter['levels'][1])
            ->orWhere('level', $filter['levels'][2])
            ->orWhere('level', $filter['levels'][3])
        ->get();*/

        $dataTexts = Text::
            where('type_english', $filter['type'])
            ->where(function($query) use ($filter){
                $query->where('level', $filter['levels'][0])
                ->orWhere('level', $filter['levels'][1])
                ->orWhere('level', $filter['levels'][2])
                ->orWhere('level', $filter['levels'][3]);
            })
        ->get();

        foreach($dataTexts as $dataText){

            $creatorName = User::where('id', $dataText['created_by_id'])->get();

            if(count($creatorName) > 0){
                $creatorName = User::where('id', $dataText['created_by_id'])->first()->user_name;
            }else{
                $creatorName = 'Desconhecido';
            }

            $Texts[] = array(
                "id" => $dataText['id'],
                "title" => $dataText['english_title'],
                "image" => $dataText['image'],
                "level" => $dataText['level'],
                "creatorName" => $creatorName
            );
        }
        
        return $Texts;
    }
    
}
