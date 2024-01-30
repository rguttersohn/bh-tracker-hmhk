<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class OMHDatasets extends Model
{
    use HasFactory;

    protected $table = 'omh_datasets';

    private function selectFields():array{
        return ['dataset_id','year','rate_per_k','capacity','county_id','region_id'];
    }
    
    public function omhData():HasMany{
        return $this->hasMany(OMHData::class, 'dataset_id')
            ->select($this->selectFields());
    }

}
