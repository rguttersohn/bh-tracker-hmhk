<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyResponseAPI extends Controller
{
    protected array $responses_select_list = ['rr.id','rr.year', 'rr.data','gender_constraints.label as gender', 'race_constraints.label as race', 'sexual_id_constraints.label as sexual_id', 'grade_constraints.label as grade'];

    protected array $allowed_filters = ['year' => 'year',  'grade_constraints.slug' => 'grade', 'race_constraints.slug' => 'race','sexual_id_constraints.slug' => 'sexual_id', 'gender_constraints.slug' => 'sex'];



    protected function getValidFilters(array $queries):array {
        
        $filters = [];

        foreach($queries as $key => $value):

            if(array_search($key, $this->allowed_filters)):
                
                $filters[$key] = $value;
            
            endif;

        endforeach;

        return $filters;

    }

    protected function getFilters():array {
        
        global $request;

        $queries = $request->all();

        $filters = $this->getValidFilters($queries);
        
        $formatted_filters =[];

        foreach($filters as $key => $value):
            
            $column = array_search($key, $this->allowed_filters);

            array_push($formatted_filters, [$column, '=', $value]);

        endforeach;

        return $formatted_filters;

    }


    protected function stagingResponsesQuery($id ):array{
        
        return DB::table('risky_responses as rr')
            ->where([['publication_status', '=', 'staging'], ['rr.risky_question_id', '=', $id], ... $this->getFilters()])
            ->orWhere([['publication_status', '=', 'production'], ['rr.risky_question_id', '=', $id], ... $this->getFilters()])
            ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
            ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
            ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
            ->join('grade_constraints', 'rr.grade_constraint_id', '=', 'grade_constraints.id' )
            ->select(...$this->responses_select_list)
            ->get()->toArray();
    }

    protected function productionResponsesQuery($id){

        return DB::table('risky_responses as rr')
            ->where([['publication_status', '=', 'production'], ['rr.risky_question_id', '=', $id], ['rr.year', '=', 1999]])
            ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
            ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
            ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
            ->join('grade_constraints', 'rr.grade_constraint_id', '=', 'grade_constraints.id' )
            ->select(...$this->responses_select_list)
            ->get()->toArray();
    }

    public function getResponses( string $env, string $id):array {
         
        $responses_query = match($env){
            'staging' => $this->stagingResponsesQuery($id),
            'production' => $this->productionResponsesQuery($id),
            default => []
        };

        return $responses_query;
    
    }

}
