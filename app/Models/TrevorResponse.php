<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrevorResponse extends Model
{
    use HasFactory;

    public function trevor_question():BelongsTo{
        return $this->belongsTo(TrevorQuestion::class);
    }
}
