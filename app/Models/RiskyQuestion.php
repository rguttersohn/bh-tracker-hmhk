<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiskyQuestion extends Model
{
    use HasFactory;

    protected $table = 'risky_questions';

    protected $attributes = [
        'publication_status' => 'draft',
    ];

    public function risky_response():HasMany {
        
        return $this->hasMany(RiskyResponse::class);

    }

}
