<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OMHDatasets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class OMHDataAPI extends Controller
{

    protected array $allowed_queries = [
        'county_id' => 'county_id',
        'region_id' => 'region_id',
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

    public function getDataSets():Collection {

        $data = Cache::rememberForever('omhDatasets',fn()=>OMHDatasets::get(['id', 'name', 'description']));
        return $data;
    }

    public function getData($env, $dataset_id):Collection{
        return OMHDatasets::where('id',$dataset_id)
        ->with('omhData', fn($query)=>$query
        ->with('county')->with('region')
        ->whereIn('publication_status', $this->getSetStatusToQuery($env)))
        ->get(['id', 'name', 'description']);
    }

    public function getStateData($env, $dataset_id):Collection{

        $status = $this->getSetStatusToQuery($env);
        
        $data = Cache::rememberForever('omhStateData',function()use($status, $dataset_id){
            return DB::table('omh_data')
            ->select('year', DB::raw('sum(capacity) as capacity'), DB::raw('sum(rate_per_k) as rate_per_k'))
            ->groupBy('year')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name', '=', 'All'],['dataset_id',$dataset_id]])
            ->whereIn('publication_status', $status)
            ->get();
        });

        return $data;

        
    }

    public function getRegionData($env, $dataset_id):Collection{
        $queries = $this->valid_queries;
        $status = $this->getSetStatusToQuery($env);
        return DB::table('omh_data')->select('year','or.name as region','or.id as region_id','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name','All'],['dataset_id', $dataset_id]])
            ->whereIn('publication_status', $status)
            ->when(isset($queries['year']), fn($query)=>$query->where('year', '=', $queries['year']))
            ->when(isset($queries['region_id']), fn($query)=>$query->where('or.id', '=', $queries['region_id']))
            ->get();     
    }
   

    public function getCountyData($env, $dataset_id):Collection{
        $queries = $this->valid_queries;

        $status = $this->getSetStatusToQuery($env);
        return DB::table('omh_data')
        ->select('year','or.name as region','or.id as region_id','oc.id as county_id','oc.name as county','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->whereIn('publication_status', $status)
            ->where([['oc.name', '!=', 'All'],['dataset_id', $dataset_id]])
            ->when(isset($queries['year']), fn($query)=>$query->where('year', '=', $queries['year']))
            ->when(isset($queries['county_id']), fn($query)=> $query->where('oc.id', '=', $queries['county_id']))
            ->get();
    }

    public function getCountyMapData($env, $dataset_id, $year):array{

        $status = $this->getSetStatusToQuery($env);

        $county_map = json_decode(file_get_contents(public_path('/maps/Counties_shoreline.json')));

    
            $data = DB::table('omh_data')
                ->select('year','or.name as region','or.id as region_id','oc.id as county_id','oc.name as county','capacity','rate_per_k',)
                ->join('omh_regions as or', 'region_id', '=', 'or.id')
                ->join('omh_counties as oc', 'county_id','=', 'oc.id')
                ->whereIn('publication_status', $status)
                ->where([['oc.name', '!=', 'All'],['dataset_id', $dataset_id],['year', $year]])
                ->get()
                ->toArray();
        
                if(!$data):
                    return [];
                endif;

                $county_map_merged = array_map(function($county)use($data){
                    
                    array_map(function($d)use($county){
                        if($county->properties->NAME === $d->county):
                            $county->properties->COUNTY_ID = $d->county_id;
                            $county->properties->REGION_ID = $d->region_id;
                            $county->properties->REGION = $d->region;
                            $county->properties->CAPACITY = $d->capacity;
                            $county->properties->RATE_PER_K = $d->rate_per_k;
                            $county->properties->YEAR = $d->year;

                        endif;

                        return $d;

                    }, $data);

                    return $county;

                }, $county_map->features);

            return $county_map_merged;

        
    }

}
