<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskyFilterAPI extends Controller
{
    
    protected array $selection = ['id', 'slug','label', 'explanation'];
    
    public function getFilters(){

        $race_query = DB::table('race_constraints')->select($this->selection)->get()->toArray();

        $sex_query = DB::table('gender_constraints')->select($this->selection)->get()->toArray();

        $sexual_id_query = DB::table('sexual_id_constraints')->select($this->selection)->get()->toArray();

        return [
            'race' => $race_query,
            'sex' => $sex_query,
            'sexual_id' => $sexual_id_query
        ];
    }
}
