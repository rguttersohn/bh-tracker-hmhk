<?php

namespace App\Models;

use App\Models\Traits\ClearCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskyResponse extends Model
{
    use HasFactory, ClearCache;

    
    protected $table = 'risky_responses';

    protected $attributes = [
        'publication_status' => 'draft',
    ];

    public static function boot(){
        
        parent::boot();

        static::clearCache('*yrbss*');

    }

    public function risky_question(): BelongsTo {
        return $this->belongsTo(RiskyQuestion::class);
    }

    public function gender_constraint(): BelongsTo {
        return $this->belongsTo(GenderConstraint::class);
    }

    public function sexual_id_constraint(): BelongsTo {
        return $this->belongsTo(SexualIDConstraint::class);
    }
   
    public function race_constraint(): BelongsTo {
        return $this->belongsTo(RaceConstraint::class);
    }

}
