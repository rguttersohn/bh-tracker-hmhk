<?php

namespace App\Models;

use App\Models\Traits\ClearCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OMHCounties extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'omh_counties';

    public static function boot(){
        
        parent::boot();

        static::clearCache("*omh*");
      

    }

    public function omhData():HasMany{
        return $this->hasMany(OMHData::class);
    }
}
