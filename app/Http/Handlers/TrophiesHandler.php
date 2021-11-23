<?php

namespace App\Http\Handlers;

/*-----------------------------Models------------------------------------------*/
use App\Models\User;
use App\Models\Trophie;
use App\Models\Subcomment;
use App\Models\Comment;
use App\Models\Comments_rating;
use App\Models\Relation;
use App\Models\Studied_text;
/*-----------------------------------------------------------------------------*/

class TrophiesHandler{

    public static function primordialTrophy($user_id){
        if($user_id < 100){
            $alreadyHaveThisTrophy = Trophie::
                where('user_id', $user_id)
                ->where('trophie_name', 'Primordial')
            ->first();

            if(!$alreadyHaveThisTrophy){
                $newTrophy = new Trophie;
                    $newTrophy->user_id = $user_id;
                    $newTrophy->trophie_name = 'Primordial';
                    $newTrophy->trophie_icon = 'primordial.png';
                    $newTrophy->trophie_description = 'Faz parte dos primeiros 10000 usuários a se juntarem a nós';
                $newTrophy->save();
            }
            
        }
    }

    public static function staffTrophy($user_id, $access){
        
        if($access > 1){
            $alreadyHaveThisTrophy = Trophie::
                where('user_id', $user_id)
                ->where('trophie_name', 'Staff')
            ->first();

            if(!$alreadyHaveThisTrophy){
                $newTrophy = new Trophie;
                    $newTrophy->user_id = $user_id;
                    $newTrophy->trophie_name = 'Staff';
                    $newTrophy->trophie_icon = 'staff.png';
                    $newTrophy->trophie_description = 'Já ganhou um cargo na equipe da adm.';
                $newTrophy->save();
            }

        }

    }

    public static function socialTrophy($user_id){
        $subComments = Subcomment::
            where('user_id', $user_id)
        ->count();

        if($subComments > 30){
            $alreadyHaveThisTrophy = Trophie::
                where('user_id', $user_id)
                ->where('trophie_name', 'Social')
            ->first();
            if(!$alreadyHaveThisTrophy){
                $newTrophy = new Trophie;
                    $newTrophy->user_id = $user_id;
                    $newTrophy->trophie_name = 'Social';
                    $newTrophy->trophie_icon = 'social.png';
                    $newTrophy->trophie_description = 'Gosta de interagir com os demais usuários.';
                $newTrophy->save();
            }
        }

    }

    public static function famousTrophy($user_id){
        $followers = relation::
            where('to_user', $user_id)
        ->count();

        if($followers > 1000){
            $alreadyHaveThisTrophy = Trophie::
                where('user_id', $user_id)
                ->where('trophie_name', 'Famosinho')
            ->first();
            if(!$alreadyHaveThisTrophy){
                $newTrophy = new Trophie;
                    $newTrophy->user_id = $user_id;
                    $newTrophy->trophie_name = 'Famosinho';
                    $newTrophy->trophie_icon = 'famosinho.png';
                    $newTrophy->trophie_description = 'Possui muitos seguidores.';
                $newTrophy->save();
            }
        }
    }

    public static function peoplesVoiceTrophy($user_id){
        $comments = Comment::
            where('user_id', $user_id)
        ->get();

        foreach($comments as $comment){
            $data = Comments_rating::
                where('id_comment', '=', $comment['id'])
                ->where('user_id', '=', $user_id)
            ->count();
            $comment['likes'] = $data;
        }

        foreach($comments as $comment){
            if($comment['likes'] > 50){
                $alreadyHaveThisTrophy = Trophie::
                    where('user_id', $user_id)
                    ->where('trophie_name', 'Voz do Povo')
                ->first();
                if(!$alreadyHaveThisTrophy){
                    $newTrophy = new Trophie;
                        $newTrophy->user_id = $user_id;
                        $newTrophy->trophie_name = 'Voz do Povo';
                        $newTrophy->trophie_icon = 'vozdopovo.png';
                        $newTrophy->trophie_description = 'Teve MUITOS apoiadores em um dos comentários feitos.';
                    $newTrophy->save();
                }
            }
        }
    }

    public static function studiousTrophy($user_id){
        $studiedText = Studied_text::
            where('user_id', $user_id)
        ->count();

        if($studiedText > 30){
            $alreadyHaveThisTrophy = Trophie::
                where('user_id', $user_id)
                ->where('trophie_name', 'Estudioso')
            ->first();
            if(!$alreadyHaveThisTrophy){
                $newTrophy = new Trophie;
                    $newTrophy->user_id = $user_id;
                    $newTrophy->trophie_name = 'Estudioso';
                    $newTrophy->trophie_icon = 'estudioso.png';
                    $newTrophy->trophie_description = 'Já marcou como estudado muitos textos.';
                $newTrophy->save();
            }
        }
    }

}
