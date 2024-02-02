<?php

namespace App\Models;

use App\Models\Traits\ClearCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class RiskyQuestion extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'risky_questions';

    protected $attributes = [
        'publication_status' => 'draft',
    ];

    public static function boot(){
        
        parent::boot();

        static::clearCache('*yrbss*');

    }

    public function risky_response():HasMany {
        
        return $this->hasMany(RiskyResponse::class);

    }

}
