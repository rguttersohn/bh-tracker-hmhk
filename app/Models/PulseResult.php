<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PulseResult extends Model
{
    use HasFactory;

    public function pulse_question():BelongsTo {
        return $this->belongsTo(PulseQuestion::class);
    }

    public function pulse_response():BelongsTo {
        return $this->belongsTo(PulseResponse::class);
    }

    public function pulse_week():BelongsTo {
        return $this->belongsTo(PulseWeek::class);
    }

    
   
}
