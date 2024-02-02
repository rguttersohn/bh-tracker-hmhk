<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OMHCounties extends Model
{
    use HasFactory;

    protected $table = 'omh_counties';

    public static function boot(){
        
        parent::boot();

        static::clearCache("*omh*");
      

    }

    public function omhData():HasMany{
        return $this->hasMany(OMHData::class);
    }
}
