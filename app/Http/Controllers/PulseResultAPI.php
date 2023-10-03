<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PulseResultAPI extends Controller
{
    use InvalidMessages;

    protected array $selection = ['ps.id', 'ps.data', 'pr.label', 'pw.week', 'pw.range'];

    public function getResults(string $env, string $id, int $week):array{
        
        if($env != 'staging' & $env != 'production'):
            
            return $this->getInvalidMessage($env);
        
        endif;


        $production_env = $env == 'production';
        $production_staging = $env == 'staging';

        return DB::table('pulse_results as ps')
            ->select($this->selection)
            ->when($production_staging, 
                function($query) use($id, $week) {
                    return $query
                        ->where([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'staging'], ['ps.pulse_week_id', '=', $week]])
                        ->orWhere([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'production'],['ps.pulse_week_id', '=', $week ]]);
                })
            ->when($production_env, function($query) use($id, $week){
                return $query
                    ->where([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'production'], ['ps.pulse_week_id', '=', $week ]]);  
            })
            ->join('pulse_responses as pr', 'pr.id', '=','ps.pulse_response_id')
            ->join('pulse_weeks as pw', 'pw.id', '=','ps.pulse_week_id')
            ->get()->toArray();
    }

}
