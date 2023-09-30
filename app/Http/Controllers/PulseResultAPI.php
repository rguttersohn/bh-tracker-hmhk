<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PulseResultAPI extends Controller
{
    use InvalidMessages;

    protected array $selection = ['ps.id', 'ps.data', 'pr.label', 'pdr.week', 'pdr.range'];

    protected function getStagingResults(string $id):array{
        
        return DB::table('pulse_results as ps')
            ->select($this->selection)
            ->where([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'staging']])
            ->orWhere([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'production']])
            ->join('pulse_responses as pr', 'pr.id', '=','ps.pulse_response_id')
            ->join('pulse_date_ranges as pdr', 'pdr.id', '=','ps.date_range_id')
            ->get()->toArray();
    
    }


    protected function getProductionResults(string $id):array {

        return DB::table('pulse_results as ps')
            ->select($this->selection)
            ->where([['ps.pulse_question_id', '=', $id], ['ps.publication_status', '=', 'production']])
            ->join('pulse_responses as pr', 'pr.id', '=','ps.pulse_response_id')
            ->join('pulse_date_ranges as pdr', 'pdr.id', '=','ps.date_range_id')
            ->get()->toArray();
    }

    public function getResults(string $env, string $id):array {

        return match($env){
            'staging' => $this->getStagingResults($id),
            'production' => $this->getProductionResults($id),
            default => $this->getInvalidMessage($env)
        };
    } 
}
