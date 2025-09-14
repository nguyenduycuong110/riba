<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryScopes;

class Scholarship  extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, QueryScopes;

    protected $fillable = [
        'id',
        'name',
        'image',
        'scholarship_catalogue_id',
        'policy_id',
        'train_id',
        'scholarship_policy',
        'introduce',
        'content',
        'publish'
    ];

    public function scholarship_schools(){
        return $this->belongsToMany(Language::class, 'scholarship_school' , 'scholarship_id', 'school_id')->withTimestamps();
    }

    protected $table = 'scholarships';
    
}