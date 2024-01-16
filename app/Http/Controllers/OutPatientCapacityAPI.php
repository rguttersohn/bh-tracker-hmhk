<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutPatientCapacityAPI extends Controller
{

    protected array $allowed_queries = [
        'county' => 'county',
        'region' => 'region',
        'year' => 'year',
    ];

    protected array $valid_queries = [];
    

    public function __construct(Request $request)
    {   
        /**run these methods on instantiation */
        $this->setValidQueries($request->all());
    }
    /** 
     * checks the url queries against the the allowed queriest list
     */
    protected function setValidQueries(array $queries):void {
        
        
        foreach($queries as $key => $value):

            if(isset($this->allowed_queries[$key])):

                $this->valid_queries[$key] = $value;
            
            endif;

        endforeach;

    }

    public function getSetStatusToQuery($env):array{

        return match($env){
            'staging' => ['staging', 'production'],
            'production' => ['production']
        };
    }


    public function getOutPatientCapacityData($env){
        $queries = $this->valid_queries;

        $status = $this->getSetStatusToQuery($env);
        return DB::table('omh_outpatient_capacities')->select('year','or.name as region','oc.name as county','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->whereIn('publication_status', $status)
            ->when(isset($queries['year']), fn($query)=>$query->where('year', '=', $queries['year']))
            ->when(isset($queries['region']), fn($query)=> $query->where('or.slug', '=', $queries['region']))
            ->when(isset($queries['county']), fn($query)=> $query->where('oc.slug', '=', $queries['county']))
            ->get();
    }
}
