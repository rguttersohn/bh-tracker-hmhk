<?php

namespace App\Http\Controllers;

use App\Models\OMHData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OMHDatasets;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class OMHDataAPI extends Controller
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

    public function getOMHDataSets():Collection {
        $data = Cache::rememberForever('omhDatasets',fn()=>OMHDatasets::get(['id', 'name', 'description']));
        return $data;
    }

    public function getOMHData($env, $dataset_id):Collection{
        return OMHDatasets::where('id',$dataset_id)
        ->with('omhData', fn($query)=>$query
        ->with('county')->with('region')
        ->whereIn('publication_status', $this->getSetStatusToQuery($env)))
        ->get(['id', 'name', 'description']);
    }

    public function getStateOMHData($env, $dataset_id):Collection{

        $status = $this->getSetStatusToQuery($env);
        
        return DB::table('omh_data')
            ->select('year', DB::raw('sum(capacity) as capacity'), DB::raw('sum(rate_per_k) as rate_per_k'))
            ->groupBy('year')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name', '=', 'All'],['dataset_id',$dataset_id]])
            ->whereIn('publication_status', $status)
            ->get();

        
    }

    public function getRegionsOMHData($env, $dataset_id):Collection{
        $queries = $this->valid_queries;
        $status = $this->getSetStatusToQuery($env);
        return DB::table('omh_data')->select('year','or.name as region','or.id as region_id','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name','All'],['dataset_id', $dataset_id]])
            ->whereIn('publication_status', $status)
            ->when(isset($queries['year']), fn($query)=>$query->where('year', '=', $queries['year']))
            ->when(isset($queries['region']), fn($query)=> $query->where('or.name', '=', $queries['region']))
            ->get();

            
    }
   

    public function getCountiesOMHData($env, $dataset_id):Collection{
        $queries = $this->valid_queries;

        $status = $this->getSetStatusToQuery($env);
        return DB::table('omh_data')->select('year','or.name as region','or.id as region_id','oc.id as county_id','oc.name as county','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->whereIn('publication_status', $status)
            ->where([['oc.name', '!=', 'All'],['dataset_id', $dataset_id]])
            ->when(isset($queries['year']), fn($query)=>$query->where('year', '=', $queries['year']))
            ->when(isset($queries['county']), fn($query)=> $query->where('oc.name', '=', $queries['county']))
            ->get();
    }

}
