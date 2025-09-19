<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;

class ScholarTrain extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $table = 'scholar_trains';

    protected $fillable = [
        'name',
        'publish',
        'order',
        'user_id'
    ];

    protected $relationable = [
        'users'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
