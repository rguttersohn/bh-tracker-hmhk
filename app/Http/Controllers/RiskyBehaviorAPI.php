<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyBehaviorAPI extends Controller
{

    private array $env_parameters = ['staging', 'production'];

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

        $query = DB::table('risky_questions')
                    ->where('publication_status','=', $env)
                    ->get()->toArray();
        
        return $query;
    }

    public function getResponses(string $env):array {
        
        if(!$this->envParameterIsValid($env)):
            
            return $this->getInvalidMessage($env);
        
        endif;

        
        $query = DB::table('risky_responses as rr')
                    ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
                    ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
                    ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
                    ->join('risky_questions', 'rr.risky_question_id', '=', 'risky_questions.id')
                    ->select('year', 'data','gender_constraints.label as gender', 'race_constraints.label as race', 'sexual_id_constraints.label as sexual_id') 
                    ->when($env == 'staging', function($query){
                        $query->where('rr.publication_status', '=', 'staging')
                            ->orWhere('rr.publication_status', '=', 'production');
                    })
                    ->when($env == 'production', function($query){
                        $query->where('rr.publication_status','=', 'production');
                    })
                    ->get()->toArray();

        return $query;
    
    }
}
