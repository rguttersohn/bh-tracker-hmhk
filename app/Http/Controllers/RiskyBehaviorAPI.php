<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyBehaviorAPI extends Controller
{

    private array $env_parameters = ['staging', 'production'];

    private array $question_select_list = ['id','slug','question','explanation','source_url','source_notes'];

    private function envParameterIsValid(string $env):bool {
 
        $is_valid = in_array($env, $this->env_parameters);

        return $is_valid;
        
    }

    private function getInvalidMessage($env):array{
        return [
            'error' => "'{$env}' is not a valid environment"
        ];
    }

    public function getQuestions(string $env):array{

        if(!$this->envParameterIsValid($env)):
            return $this->getInvalidMessage($env);
        endif;

        $query = DB::table('risky_questions as rs')
                    ->select(...$this->question_select_list)
                    ->when($env == 'staging', function($query){
                        $query->where('rs.publication_status', '=', 'staging')
                            ->orWhere('rs.publication_status', '=', 'production');
                    })
                    ->when($env == 'production', function($query){
                        $query->where('rs.publication_status','=', 'production');
                    })
                    ->get()->toArray();
        
        return $query;
    }

    public function getQuestion(string $env, string $id):array{

        if(!$this->envParameterIsValid($env)):
            
            return $this->getInvalidMessage($env);
        
        endif;

        $question_query = DB::table('risky_questions as rs')
            ->select($this->question_select_list)
            ->where('rs.id', '=', $id)
            ->when($env == 'staging', function($query){
                $query->where('rs.publication_status', '=', 'staging')
                    ->orWhere('rs.publication_status', '=', 'production');
            })
            ->when($env == 'production', function($query){
                $query->where('rs.publication_status','=', 'production');
            })->get()->toArray();
    
        return [
            'question' => $question_query,
            'responses' => $this->getResponses($env, $id)
        ];
    }

    public function getResponses(string $env, string $id):array {
        
        if(!$this->envParameterIsValid($env)):
            
            return $this->getInvalidMessage($env);
        
        endif;

        
        $responses_query = DB::table('risky_responses as rr')
                    ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
                    ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
                    ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
                    ->select('rr.id','rr.year', 'rr.data','gender_constraints.label as gender', 'race_constraints.label as race', 'sexual_id_constraints.label as sexual_id')
                    ->where('rr.risky_question_id', '=', $id) 
                    ->when($env == 'staging', function($query){
                        $query->where('rr.publication_status', '=', 'staging')
                            ->orWhere('rr.publication_status', '=', 'production');
                    })
                    ->when($env == 'production', function($query){
                        $query->where('rr.publication_status','=', 'production');
                    })
                    ->get()->toArray();

        return $responses_query;
    
    }
}
