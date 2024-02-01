<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\OMHDatasets;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Traits\CacheKey;


class OMHDataAPI extends Controller
{
    use CacheKey;

    
  
    public function getSetStatusToQuery($env):array{

        return match($env){
            'staging' => ['staging', 'production'],
            'production' => ['production']
        };
    }

    public function getDataSets($env):Collection | array {
        $cache_key = static::setOMHKey($env,);

        $cached_data = Redis::get($cache_key);

        if($cached_data):

            return json_decode($cached_data);

        endif;
        
        $data = OMHDatasets::get(['id', 'name', 'description']);
        
        Redis::set('omh:datasets', json_encode($data));

        return $data;
    }

    public function getData($env, $dataset_id):Collection{
        return OMHDatasets::where('id',$dataset_id)
        ->with('omhData', fn($query)=>$query
        ->with('county')->with('region')
        ->whereIn('publication_status', $this->getSetStatusToQuery($env)))
        ->get(['id', 'name', 'description']);
    }

    public function getStateData($env, $dataset_id):Collection | array{

        $status = $this->getSetStatusToQuery($env);

        $cache_key = static::setOMHKey($env, $dataset_id, 'state');
        $cached_data = Redis::get($cache_key);

        if($cached_data){
            
            return json_decode($cached_data);
        }
        
        $data = DB::table('omh_data')
            ->select('year', 'or.name as region', 'or.id as region_id', 'capacity', 'rate_per_k')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->where([['oc.name', '=', 'All'],['or.name', '=', 'All'],['dataset_id',$dataset_id]])
            ->whereIn('publication_status', $status)
            ->get();

        Redis::set($cache_key, json_encode($data));

        return $data;

    }

    public function getRegionsData($env, $dataset_id):Collection | array{
        $status = $this->getSetStatusToQuery($env);
        $cache_key = static::setOMHKey($env, $dataset_id, 'regions');

        $cached_data = Redis::get($cache_key);
        
        if($cached_data){
            return json_decode($cached_data);
        }

        $data = DB::table('omh_data')->select('year','or.name as region','or.id as region_id','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name','All'],['dataset_id', $dataset_id]])
            ->whereIn('publication_status', $status)
            ->get();
        
        Redis::set($cache_key, json_encode($data));
            
        return $data;
    }

    public function getRegionData($env, $dataset_id, $region_id):Collection | array{
        
        $status = $this->getSetStatusToQuery($env);
        $cache_key = static::setOMHKey($env, $dataset_id, 'regions', $region_id);

        $cached_data = Redis::get($cache_key);
        
        if($cached_data){
            return json_decode($cached_data);
        }

        $data = DB::table('omh_data')->select('year','or.name as region','or.id as region_id','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->where([['oc.name','All'],['dataset_id', $dataset_id],['region_id', $region_id]])
            ->whereIn('publication_status', $status)
            ->get();
        
        Redis::set($cache_key, json_encode($data));
            
        return $data;
    }
   

    public function getCountiesData($env, $dataset_id):Collection | array{

        $status = $this->getSetStatusToQuery($env);
        $cache_key = static::setOMHKey($env, $dataset_id, 'counties');

        $cached_data = Redis::get($cache_key);

        if($cached_data):
            return json_decode($cached_data);
        endif;

        $data = DB::table('omh_data')
            ->select('year','or.name as region','or.id as region_id','oc.id as county_id','oc.name as county','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->whereIn('publication_status', $status)
            ->where([['oc.name', '!=', 'All'],['dataset_id', $dataset_id]])
            ->get();

        Redis::set($cache_key, json_encode($data));

        return $data;
    }

    public function getCountyData($env, $dataset_id, $county_id):Collection | array{

        $status = $this->getSetStatusToQuery($env);
        $cache_key = static::setOMHKey($env, $dataset_id, 'counties', $county_id);

        $cached_data = Redis::get($cache_key);

        if($cached_data):
            return json_decode($cached_data);
        endif;

        $data = DB::table('omh_data')
            ->select('year','or.name as region','or.id as region_id','oc.id as county_id','oc.name as county','capacity','rate_per_k',)
            ->join('omh_regions as or', 'region_id', '=', 'or.id')
            ->join('omh_counties as oc', 'county_id','=', 'oc.id')
            ->whereIn('publication_status', $status)
            ->where([['dataset_id', $dataset_id],['county_id', $county_id]])
            ->get();

        Redis::set($cache_key, json_encode($data));

        return $data;
    }

    public function getCountyMapData($env, $dataset_id, $year):array{

        $status = $this->getSetStatusToQuery($env);

        $cache_key = static::setOMHKey($env, $dataset_id, 'map', $year);

        $cached_data = Redis::get($cache_key);

        if($cached_data){

            return json_decode($cached_data);
        }

        $county_map = json_decode(file_get_contents(public_path('/maps/Counties_Shoreline.json')));

    
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
        
        Redis::set($cache_key, json_encode($county_map_merged));

        return $county_map_merged;

        
    }

}
