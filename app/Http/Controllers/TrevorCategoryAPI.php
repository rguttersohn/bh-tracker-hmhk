<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\InvalidMessages;

class TrevorCategoryAPI extends Controller
{   
    
    use InvalidMessages;

    protected array $selection = ['id', 'question','explanation', 'source_url', 'source_notes'];

    protected function getStagingQuestions($id){
        
        $questions = DB::table('trevor_questions')->select($this->selection)
            ->where([['trevor_category_id', '=', $id],['publication_status', '=', 'staging']])
            ->orWhere([['trevor_category_id', '=', $id],['publication_status', '=', 'production']])
            ->get()->toArray();

        foreach($questions as $question):
            
            $question->responses = (new TrevorResponseAPI())->getStagingResponses($question->id);

        endforeach;

        return $questions;
    }

    protected function getProductionQuestions($id){
        
        $questions = DB::table('trevor_questions')->select($this->selection)
            ->where([['trevor_category_id', '=', $id],['publication_status', '=', 'production']])
            ->get()->toArray();
        
        foreach($questions as $question):
            
            $question->responses = (new TrevorResponseAPI)->getProductionResponses($question->id);

        endforeach;

        return $questions;
    }

    public function getCategories($env):array {

        if($env !== 'production' & $env !== 'staging'){
            
            return $this->getInvalidMessage($env);

        }
            
        return DB::table('trevor_categories')->select('id', 'slug', 'label')->get()->toArray();
    }

    public function getCategory($env, $id):array {
        
        if($env !== 'staging' & $env !== 'production'):
            
            return $this->getInvalidMessage($env);
       
        endif;
        
        $questions = match($env){
            'staging' => $this->getStagingQuestions($id),
            'production' => $this->getProductionQuestions($id),
        };

        return [
            'category' => DB::table('trevor_categories')->select('id', 'slug', 'label')->where('id', '=', $id)->get(),
            'questions' => $questions
        ];
    }
}
