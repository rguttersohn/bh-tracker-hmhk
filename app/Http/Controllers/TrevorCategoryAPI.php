<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TrevorQuestion;
use App\Models\TrevorCategory;

class TrevorCategoryAPI extends Controller
{

    use InvalidMessages;

    protected function getStagingQuestions($id){
        return TrevorQuestion::select('id', 'question','explanation', 'source_url', 'source_notes')
            ->where('publication_status', '=', 'staging')
            ->orWhere('publication_status', '=', 'production')
            ->with('trevor_response:id,data,year,trevor_question_id')
            ->where('trevor_category_id', '=', $id)
            ->get();
    }

    protected function getProductionQuestions($id){
        return TrevorQuestion::select('id', 'question','explanation', 'source_url', 'source_notes')
            ->where('publication_status', '=', 'production')
            ->with('trevor_response:id,data,year,trevor_question_id')
            ->where('trevor_category_id', '=', $id)
            ->get();
    }

    public function getCategories($env):array {

        if($env !== 'production' & $env !== 'staging'){
            
            return $this->getInvalidMessage($env);

        }
            
        return TrevorCategory::select('id', 'slug', 'label')->get()->toArray();
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
            'category' => TrevorCategory::select('id', 'slug', 'label')->where('id', '=', $id)->get(),
            'questions' => $questions
        ];
    }
}
