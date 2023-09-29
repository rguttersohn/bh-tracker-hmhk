<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PulseDateRange extends Model
{
    use HasFactory;

    public function pulse_result():HasMany{
        return $this->hasMany(PulseResult::class);
    }
}
