<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OutPatientCapacity extends Model
{
    
    use HasFactory;

    protected $table = 'omh_outpatient_capacities';
    
    protected $attributes = [
        'publication_status' => 'draft',
    ];

    public function regions():BelongsTo{
        return $this->belongsTo(related: OMHRegions::class, foreignKey: 'region_id');
    }   

    public function counties():BelongsTo{
        return $this->belongsTo(related: OMHCounties::class, foreignKey: 'county_id');
    }
    
}
