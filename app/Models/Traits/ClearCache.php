<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;


trait ClearCache {

    public static function deleteKeys(array $keys):void{
        
        $redis = new \Redis();
        $prefix = $redis->getOption(\Redis::OPT_PREFIX); // keys already have prefix, so we clear until delete finish.
        $redis->setOption(\Redis::OPT_PREFIX, '');
        $redis->connect('redis');

        foreach($keys as $key){
            $redis->unlink($key);   
        }
        
        $redis->setOption(\Redis::OPT_PREFIX, $prefix);


    }
    
    public static function clearCache(string $key_pattern):void{
        
        if (empty($key_pattern)) { 
            return;
        }

        $keys = Redis::scan($key_pattern);

        if(!$keys):
            return;
        endif;

        static::saved(fn()=>static::deleteKeys($keys));
        static::created(fn()=>static::deleteKeys($keys));
        static::updated(fn()=>static::deleteKeys($keys));
        static::deleted(fn()=>static::deleteKeys($keys));
    }
}