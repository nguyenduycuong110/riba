<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasQuery;

class SchoolCity extends Model 
{
    use HasFactory, Notifiable, SoftDeletes, HasQuery;
    
    protected $fillable = [
        'id',
        'area_id',
        'name',
        'publish',
        'user_id',
    ];
    
    protected $casts = [
       
    ];
    
    protected $relationable = [
       'users', 'school_areas'
    ];

    protected $table = 'school_cities';
    
    public function getRelationable(){
        return $this->relationable;
    }
    
    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function school_areas(): BelongsTo {
        return $this->belongsTo(SchoolArea::class, 'area_id', 'id');
    }
}