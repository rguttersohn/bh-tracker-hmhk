<?php

namespace App\Models;

use App\Models\Traits\ClearCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RaceConstraint extends Model
{
    use HasFactory, ClearCache;

    public static function boot(){
        
        parent::boot();

        static::clearCache('*yrbss*');

    }

    public function yrbss_response():HasMany {
        
        return $this->hasMany(RiskyResponse::class);
        
    }
    
}
