<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GenderConstraint extends Model
{
    use HasFactory;

    protected $table = 'gender_constraints';

    public function yrbss_response():HasMany {
        
        return $this->hasMany(RiskyResponse::class);
        
    }
}
