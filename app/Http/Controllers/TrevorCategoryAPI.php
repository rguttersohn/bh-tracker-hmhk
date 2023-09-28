<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TrevorQuestion;
use App\Models\TrevorCategory;

class TrevorCategoryAPI extends Controller
{
    public function getCategories():array {
        return TrevorCategory::select('id', 'slug', 'label')->get()->toArray();
    }

    public function getCategory($env, $id):array {
        
        return [
            'category' => TrevorCategory::select('id', 'slug', 'label')->where('id', '=', $id)->get(),
            'questions' => TrevorQuestion::select('id', 'question','explanation', 'source_url', 'source_notes')->with('trevor_response:id,data,year,trevor_question_id')->where('trevor_category_id', '=', $id)->get()
        ];
    }
}
