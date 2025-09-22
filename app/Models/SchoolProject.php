<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasQuery;

class SchoolProject extends Model 
{
    use HasFactory, Notifiable, SoftDeletes, HasQuery;
    
    protected $fillable = [
        'id',
        'name',
        'publish',
        'user_id',
    ];
    
    protected $casts = [
       
    ];
    
    protected $relationable = [
       'users'
    ];

    protected $table = 'school_projects';
    
    public function getRelationable(){
        return $this->relationable;
    }
    
    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}