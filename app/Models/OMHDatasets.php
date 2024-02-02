<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\ClearCache;

class OMHDatasets extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'omh_datasets';

    public static $cache_key = 'omh:datasets';

    public static function boot(){
        
        parent::boot();

        static::clearCache('*omh*');

    }

    private function selectFields():array{
        return ['dataset_id','year','rate_per_k','capacity','county_id','region_id'];
    }
    
    public function omhData():HasMany{
        return $this->hasMany(OMHData::class, 'dataset_id')
            ->select($this->selectFields());
    }

}
