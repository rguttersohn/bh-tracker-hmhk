<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PulseWeekAPI extends Controller
{
    public function getWeeks ($id, $env):array {
        $weeks = DB::table('pulse_weeks')->get()->toArray();
        
        foreach($weeks as $week):
            $week_id = $week->id;
            $week->responses = (new PulseResultAPI())->getResults($env, $id, $week_id );

        endforeach;

        return $weeks;
    }
}
