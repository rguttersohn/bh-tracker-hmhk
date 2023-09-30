<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RiskyResponseAPI;
use App\Http\Controllers\RiskyFilterAPI;
use Illuminate\Http\Request;


class RiskyQuestionAPI extends Controller
{

    use InvalidMessages;

    protected array $selection = ['id','question','explanation','source_url','source_notes'];

    protected function stagingQuestionQuery(string $id):array {

        return DB::table('risky_questions')
        ->select($this->selection)
        ->where([['publication_status', '=', 'staging'],['id','=', $id]])
        ->orWhere([['publication_status', '=', 'production'],['id','=', $id]])
        ->get()->toArray();

    }

    protected function productionQuestionQuery(string $id):array {
        
        return DB::table('risky_questions')
        ->select($this->selection)
        ->where([['publication_status', '=', 'production'],['id','=', $id]])
        ->get()->toArray();

    }

    protected function stagingQuestionsQuery(): array {
        return DB::table('risky_questions as rs')
        ->select(...$this->selection)
        ->where('publication_status', '=', 'staging')
        ->orWhere('publication_status', '=', 'production')
        ->get()->toArray();
    }

    protected function productionQuestionsQuery(): array {
        return DB::table('risky_questions as rs')
        ->select(...$this->selection)
        ->where('publication_status', '=', 'production')
        ->get()->toArray();
    }

    public function getQuestions(string $env):array{
        
        $response= match($env){
            'staging' => $this->stagingQuestionsQuery(),
            'production' => $this->productionQuestionsQuery(),
            default => $this->getInvalidMessage($env),
        };

        return $response;
    }


    public function getQuestion(string $env, string $id, Request $request):array{

        /** Determine the query to run based ont the env */

        $question_query = match($env){
            'staging' => $this->stagingQuestionQuery($id),
            'production' => $this->productionQuestionQuery($id),
            default => $this->getInvalidMessage($env)
        };
            
        return [
            'question' => $question_query,
            'responses' => (new RiskyResponseAPI($request))->getResponses($env, $id),
            'filters' => (new RiskyFilterAPI())->getFilters($env, $id)
        ];
    }


}
