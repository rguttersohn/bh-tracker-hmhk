<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrevorQuestion extends Model
{
    use HasFactory;

    public function trevor_category():BelongsTo{
        return $this->belongsTo(TrevorCategory::class);
    }

    public function trevor_response():HasMany{
        return $this->hasMany(TrevorResponse::class);
    }
}
