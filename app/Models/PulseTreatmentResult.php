<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PulseTreatmentResult extends Model
{
    use HasFactory;

    public function pulse_treatment_category():BelongsTo {
        return $this->belongsTo(PulseTreatmentCategory::class);
    }

    public function pulse_treatment_response():BelongsTo {
        return $this->belongsTo(PulseTreatmentRespons::class);
    }
    
}
