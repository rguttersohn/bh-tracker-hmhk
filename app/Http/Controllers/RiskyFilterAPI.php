<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyFilterAPI extends Controller
{   

  
    protected array $selection = ['id', 'slug','label', 'explanation'];
    
    public function getFilters(string $id){


        $race_query = DB::table('race_constraints')->
            select('race_constraints.id', 'slug','label', 'explanation')
            ->join('risky_responses', 'race_constraints.id','=', 'race_constraint_id')
            ->where('risky_responses.risky_question_id', '=', $id)
            ->get()->toArray();

        $sex_query = DB::table('gender_constraints')
            ->select('gender_constraints.id', 'slug','label', 'explanation')
            ->join('risky_responses', 'gender_constraints.id','=', 'race_constraint_id')
            ->where('risky_responses.risky_question_id', '=', $id)
            ->get()->toArray();

        $sexual_id_query = DB::table('sexual_id_constraints')
        ->select('sexual_id_constraints.id', 'slug','label', 'explanation')
        ->join('risky_responses', 'sexual_id_constraints.id','=', 'race_constraint_id')
        ->where('risky_responses.risky_question_id', '=', $id)
        ->get()->toArray();

        return [
            'race' => $race_query,
            'sex' => $sex_query,
            'sexual_id' => $sexual_id_query
        ];
    }
}
