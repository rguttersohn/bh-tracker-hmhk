<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CacheKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RiskyFilterAPI extends Controller
{   

    use CacheKey;

    protected function getStagingFilters(string $id){

        $race_query = DB::table('race_constraints')->
            select('race_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'race_constraints.id','=', 'race_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'staging'] ])
            ->orWhere([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production'] ])
            ->get()->toArray();

        $sex_query = DB::table('gender_constraints')
            ->select('gender_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'gender_constraints.id','=', 'gender_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'staging']])
            ->orWhere([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production']])
            ->get()->toArray();

        $sexual_id_query = DB::table('sexual_id_constraints')
            ->select('sexual_id_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'sexual_id_constraints.id','=', 'sexual_id_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'staging']])
            ->orWhere([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production']])
            ->get()->toArray();

        $year_query = DB::table('risky_responses as rr')
            ->select('year')
            ->distinct()
            ->where([['rr.risky_question_id', '=', $id], ['rr.publication_status', '=', 'staging']])
            ->orWhere([['rr.risky_question_id', '=', $id], ['rr.publication_status', '=', 'production']])
            ->get()->toArray();

        return [
            'race' => $race_query,
            'sex' => $sex_query,
            'sexual_id' => $sexual_id_query,
            'year' => $year_query
        ];
    }

    protected function getProductionFilters(string $id){

        $race_query = DB::table('race_constraints')->
            select('race_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'race_constraints.id','=', 'race_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production'] ])
            ->get()->toArray();

        $sex_query = DB::table('gender_constraints')
            ->select('gender_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'gender_constraints.id','=', 'gender_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production']])
            ->get()->toArray();

        $sexual_id_query = DB::table('sexual_id_constraints')
            ->select('sexual_id_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'sexual_id_constraints.id','=', 'sexual_id_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production']])
            ->get()->toArray();
        
        $year_query = DB::table('risky_responses as rr')
            ->select('year')
            ->distinct()
            ->where([['rr.risky_question_id', '=', $id], ['rr.publication_status', '=', 'production']])
            ->get()->toArray();

        

        return [
            'race' => $race_query,
            'sex' => $sex_query,
            'sexual_id' => $sexual_id_query,
            'year' => $year_query
        ];
    }

    public function getFilters(string $env, string $id):array{
        $cache_key = static::setRiskKeys($env, $id, 'filters');

        $cached_data = Redis::get($cache_key);

        if($cached_data):
            return json_decode($cached_data);
        endif;

        $filters = match($env){
            'production' => $this->getProductionFilters($id),
            'staging' => $this->getStagingFilters($id),
            default => [],
         };

         Redis::set($cache_key, json_encode($filters));

         return $filters;
    }

}
