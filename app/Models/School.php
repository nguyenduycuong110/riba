<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
   use HasFactory, SoftDeletes, HasQuery;

    protected $fillable = [
        'area_id',
        'code',
        'rank', 
        'panorama', 
        'information',
        'video',
        'logo',
        'address',
        'phone',
        'email',
        'link_website',
        'map',
        'training_major',
        'question_answer',
        'likes',
        'favorites',
        'view',
        'image',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
        'viewed',
    ];

    protected $casts = [
        'album' => 'json',
        'information' => 'json',
        'training_major' => 'json',
        'question_answer' => 'json',
    ];

    protected $relationable = [
       'users', 'school_catalogues' , 'school_projects' , 'school_posts' , 'school_scholars' , 'reviews' , 'languages'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    protected $table = 'schools';

    public function languages(){
        return $this->belongsToMany(Language::class, 'school_language')
        ->withPivot(
            'school_id',
            'language_id',
            'name',
            'canonical',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description',
            'content'
        )->where('language_id', config('app.language_id'));
    }

    public function school_catalogues(){
        return $this->belongsToMany(SchoolCatalogue::class, 'school_catalogue_school' , 'school_id', 'school_catalogue_id');
    }

    public function school_projects(){
        return $this->belongsToMany(SchoolProject::class, 'school_project' , 'school_id', 'project_id');
    }

    public function school_posts(){
        return $this->belongsToMany(Post::class, 'school_post' , 'school_id', 'post_id');
    }

    public function school_scholars(){
        return $this->belongsToMany(Scholar::class, 'school_scholar' , 'school_id', 'scholar_id');
    }

    public function school_areas(): BelongsTo{
        return $this->belongsTo(SchoolArea::class, 'area_id', 'id');
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reviews(){
        return $this->morphMany(Review::class, 'reviewable');
    }


}
