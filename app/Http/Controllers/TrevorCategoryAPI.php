<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrevorCategoryAPI extends Controller
{
    public function getCategories():array {
        return DB::table('trevor_categories')->select('id', 'slug', 'label')->get()->toArray();
    }

    public function getCategory($env, $id):array {

        $category_query = DB::table('trevor_categories')
            ->select('id', 'slug', 'label')
            ->where('id', '=', $id)
            ->get()->toArray();

        $questions_query = DB::table('trevor_questions as tq')
            ->select('tq.id','question')
            ->where('tq.trevor_category_id', '=', $id)->get()->toArray();

        foreach($questions_query as &$question){

            $response_query = DB::table('trevor_responses as tr')
            ->select('tr.id','tr.data', 'tr.year')
            ->where('tr.trevor_question_id', '=', $question->id)->get()->toArray();

            $question->responses = $response_query;
        }

        return [
            'category' => $category_query,
            'questions' => $questions_query
        ];
    }
}
