<?php

namespace App\Http\Controllers\Traits;

trait CacheKey {
    
    private static function setOMHKey($env, int | null $dataset_id = null, string | null $geo = null, int | null $geo_id = null ):string{
        $cache_key = "{$env}:omh:datasets:";
        
        if($dataset_id):
            $cache_key .= "{$dataset_id}:";
        endif;

        if($geo):
            $cache_key .= "{$geo}:";
        endif;

        if($geo_id):
            $cache_key .= "{$geo_id}";
        endif;


        return $cache_key;
    }


    private static function setRiskKeys($env, int | null $question_id = null, string | null $filter_or_response = null, array | null $queries = null) {
        
        $cache_key = "{$env}:yrbss:questions:";

        if($question_id):
            $cache_key .= "{$question_id}:";
        endif;

        if($filter_or_response):
            $cache_key .= "{$filter_or_response}:";
        endif;

        if(!$queries):
            
            return $cache_key;
        
        endif;

        foreach($queries as $key=>$value):
            
            $cache_key .= ":{$key}:{$value}";
        
        endforeach;

        return $cache_key;
        
    }
}
