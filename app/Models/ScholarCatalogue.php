<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;

class ScholarCatalogue extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $languageId;

    protected $fillable = [
        'id',
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        // 'follow',
        'order',
        'user_id',
        // 'short_name'
    ];

    

    protected $casts = [
        'album' => 'json'
    ];

    protected $relationable = [
        'users', 'languages'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'scholar_catalogue_language' , 'scholar_catalogue_id', 'language_id')
        ->withPivot(
            'scholar_catalogue_id',
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
     
    public function setLanguage($language){
        $this->languageId = $language;
        return $this;
    }

   
   

}
