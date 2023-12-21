<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyYearsAPI extends Controller
{
    protected function getStagingYears(string $id){

        $years_query = DB::table('risky_responses as rr')->
            select('rr.year')
            ->where('rr.publication_status', '=', 'staging')
            ->orWhere('rr.publication_status', '=', 'production')
            ->distinct()    
            ->get()->toArray();

        return [
            'years' => $years_query,
        ];
    }

    protected function getProductionYears(string $id){

        $years_query = DB::table('race_constraints')->
            select('race_constraints.id', 'slug','label', 'explanation')
            ->distinct()
            ->join('risky_responses', 'race_constraints.id','=', 'race_constraint_id')
            ->where([['risky_responses.risky_question_id', '=', $id], ['risky_responses.publication_status', '=', 'production'] ])
            ->get()->toArray();
            
        return [
            'years' => $years_query,
            
        ];
    }

    public function getYears(string $env, string $id):array{

        return match($env){
            'production' => $this->getProductionYears($id),
            'staging' => $this->getStagingYears($id),
            default => [],
         };
    }  
}
