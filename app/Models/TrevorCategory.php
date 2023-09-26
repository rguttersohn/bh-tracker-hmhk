<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrevorCategory extends Model
{
    use HasFactory;

    public function trevor_question ():HasMany{
        return $this->hasMany(TrevorQuestions::class);
    }
}
