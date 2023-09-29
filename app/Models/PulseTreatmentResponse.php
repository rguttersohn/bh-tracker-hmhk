<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PulseTreatmentResponse extends Model
{
    use HasFactory;

    public function pulse_treatment_result():HasMany{
        return $this->hasMany(PulseTreatmentResult::class);
    }
}
