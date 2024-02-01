<?php

namespace App\Http\Controllers\Traits;

trait CacheKey {
    
    public static function setOMHKey($env, int | null $dataset_id = null, string | null $geo = null, int | null $geo_id = null ):string{
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
}