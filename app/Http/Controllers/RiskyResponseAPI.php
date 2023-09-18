<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyResponseAPI extends Controller
{
    protected array $selections = ['rr.id','rr.year', 'rr.data','gender_constraints.label as gender', 'race_constraints.label as race', 'sexual_id_constraints.label as sexual_id', 'grade_constraints.label as grade'];

    /** bind  query params to column 
     * key is query param
     * value is the associated column
    */

    protected array $allowed_queries = [
        'id' =>'rr.id', 
        'year' => 'year',  
        'grade' => 'grade_constraints.slug', 
        'race' => 'race_constraints.slug',
        'sexual_id' => 'sexual_id_constraints.slug', 
        'gender_id' => 'gender_constraints.slug'
    ];



    protected function getValidQueries(array $queries):array {
        
        $valid_queries = [];
        
        foreach($queries as $key => $value):

            if(isset($this->allowed_queries[$key])):

                $valid_queries[$key] = $value;
            
            endif;

        endforeach;

        return $valid_queries;

    }

    protected function getFilters():array {
        
        global $request;

        $validated_queries = $this->getValidQueries($request->all());
        
        $formatted_filters = [];

        foreach($validated_queries as $key => $value):

            if(str_starts_with($key, 'sort_asc' || 'sort_desc')):
                
                continue;
            
            endif;

            array_push($formatted_filters, [$this->allowed_queries[$key], '=', $value]);
        
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
            ->select(...$this->selections)
            ->get()->toArray();
    }

    protected function productionResponsesQuery($id){

        return DB::table('risky_responses as rr')
            ->where([['publication_status', '=', 'production'], ['rr.risky_question_id', '=', $id], ['rr.year', '=', 1999]])
            ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
            ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
            ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
            ->join('grade_constraints', 'rr.grade_constraint_id', '=', 'grade_constraints.id' )
            ->select(...$this->selections)
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
