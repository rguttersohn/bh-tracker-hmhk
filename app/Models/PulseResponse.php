<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PulseResponse extends Model
{
    use HasFactory;

    public function pulse_result():HasMany{
        return $this->hasMany(PulseResult::class);
    }

    public function pulse_question():BelongsTo{
        return $this->belongsTo(PulseQuestion::class);
    }
}
