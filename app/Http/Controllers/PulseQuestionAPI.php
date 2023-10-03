<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PulseQuestion;
use Illuminate\Support\Facades\DB;

class PulseQuestionAPI extends Controller
{
    use InvalidMessages;

   protected function getStagingQuestions(){
        
        return DB::table('pulse_questions')
            ->select('id', 'question', 'explanation', 'source_url', 'source_notes')
            ->where('publication_status', '=', 'staging')
            ->orWhere('publication_status', '=', 'production')
            ->get()->toArray();

    }

    protected function getProductionQuestions(){
        
        return DB::table('pulse_questions')
            ->select('id', 'question', 'explanation', 'source_url', 'source_notes')
            ->where('publication_status', '=', 'staging')
            ->get()->toArray();

    }

    protected function getStagingQuestion($id){
        return DB::table('pulse_questions')
            ->select('id', 'question', 'explanation', 'source_url', 'source_notes')
            ->where([['id', '=', $id],['publication_status', '=', 'staging']])
            ->orWhere([['id', '=', $id],['publication_status', '=', 'production']])
            ->get()->toArray();
    }

    protected function getProductionQuestion($id){
        return DB::table('pulse_questions')
            ->select('id', 'question', 'explanation', 'source_url', 'source_notes')
            ->where([['id', '=', $id],['publication_status', '=', 'production']])
            ->get()->toArray();
    }


    public function getPulseQuestions($env){
        return match($env){
            'staging' => $this->getStagingQuestions(),
            'production' => $this->getProductionQuestions()
        };
    }

    public function getPulseQuestion($env, $id){
        $question = match($env){
            'staging' => $this->getStagingQuestion($id),
            'production' => $this->getProductionQuestion($id),
            default => $this->getInvalidMessage($env)
        };

        return ['question' => $question,
                'weeks' => (new PulseWeekAPI())->getWeeks($id, $env),
                ];
    }

}
