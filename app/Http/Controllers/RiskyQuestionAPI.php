<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CacheKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Traits\InvalidMessages;


class RiskyQuestionAPI extends Controller
{

    use InvalidMessages, CacheKey;

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
        
        $cache_key = static::setRiskKeys($env);

        $cached_data = Redis::get($cache_key);

        if($cached_data){

            return json_decode($cached_data);
        }

        $response= match($env){
            'staging' => $this->stagingQuestionsQuery(),
            'production' => $this->productionQuestionsQuery(),
            default => $this->getInvalidMessage($env),
        };

        Redis::set($cache_key,json_encode($response));

        return $response;
    }


    public function getQuestion(string $env, string $id):array{

        /** Determine the query to run based ont the env */
        $cache_key = static::setRiskKeys($env, $id);

        $cached_data = Redis::get($cache_key);

        if($cached_data):
            return json_decode($cached_data);
        endif;

        $question_query = match($env){
            'staging' => $this->stagingQuestionQuery($id),
            'production' => $this->productionQuestionQuery($id),
            default => $this->getInvalidMessage($env)
        };

        Redis::set($cache_key, json_encode(['question' => $question_query]));
            
        return [
            'question' => $question_query,
        ];
    }


}
