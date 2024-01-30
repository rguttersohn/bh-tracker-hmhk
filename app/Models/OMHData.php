<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;


class OMHData extends Model
{
    
    use HasFactory;

    protected $table = 'omh_data';
    
    protected $attributes = [
        'publication_status' => 'draft',
    ];

   
    public function selectFields():array{
        return ['id', 'name'];
    }


    public function region():BelongsTo{
        return $this->belongsTo(related: OMHRegions::class, foreignKey: 'region_id')
            ->select($this->selectFields());
    }   

    public function county():BelongsTo{
        return $this->belongsTo(related: OMHCounties::class, foreignKey: 'county_id')
            ->select($this->selectFields());;
    }

    public function datasets():BelongsTo{
        return $this->belongsTo(related: OMHDatasets::class, foreignKey: 'dataset_id')
        ->select(['id','name', 'description']);
    }
    
}
