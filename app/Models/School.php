<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryScopes;

class School extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, QueryScopes;

    protected $fillable = [
        'id',
        'code',
        'name',
        'email',
        'image',
        'phone',
        'address',
        'map',
        'link_website',
        'logo', 
        'album', 
        'video',
        'description',
        'panorama', 
        'information',
        'introduction',
        'publish'
    ];

    protected $table = 'schools';
    
}