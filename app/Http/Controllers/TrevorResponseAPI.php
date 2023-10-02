<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrevorResponseAPI extends Controller
{   

    protected array $selection = ['id','year', 'data'];

    public function getStagingResponses(string $question_id):array {

        return DB::table('trevor_responses')->select($this->selection)
            ->where([['trevor_question_id', '=', $question_id], ['publication_status', '=', 'staging']])
            ->orWhere([['trevor_question_id', '=', $question_id], ['publication_status', '=', 'production']])
            ->get()->toArray();

    }

    public function getProductionResponses (string $question_id):array {

        return DB::table('trevor_responses')->select($this->selection)
            ->where([['trevor_question_id', '=', $question_id], ['publication_status', '=', 'production']])
            ->get()->toArray();

    }
    
}
