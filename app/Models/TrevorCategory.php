<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TrevorCategory extends Model
{
    use HasFactory;

    protected $table = 'trevor_categories';
    
    public function trevor_question():HasMany{
        return $this->hasMany(TrevorQuestion::class);
    }

    public function trevor_response():HasManyThrough {
        return $this->hasManyThrough(TrevorResponse::class , TrevorQuestion::class);
    }
}
