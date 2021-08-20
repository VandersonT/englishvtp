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
    
}
