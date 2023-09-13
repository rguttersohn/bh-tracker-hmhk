<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeConstraint extends Model
{
    use HasFactory;

    protected $table = 'grade_constraints';

    public function risky_response():hasMany{
        
        return $this->hasMany(RiskyResponse::class);
    }
}
