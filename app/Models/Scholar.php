<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;

class Scholar extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $languageId;

    protected $fillable = [
        'id',
        'album',
        'policy_id',
        'train_id',
        'scholar_policy',
        'image',
        'publish',
        'order',
        'user_id',
    ];

    protected $casts = [
        'album' => 'json',
        'scholar_policy' => 'json'
    ];

    protected $relationable = [
        'users', 'scholar_catalogues', 'scholar_schools', 'scholar_policies', 'scholar_trains', 'languages'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function scholar_catalogues(){
        return $this->belongsToMany(ScholarCatalogue::class, 'scholar_catalogue_scholar' , 'scholar_id', 'scholar_catalogue_id');
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scholar_policies(): BelongsTo{
        return $this->belongsTo(ScholarPolicy::class, 'policy_id', 'id');
    }

    public function scholar_trains(): BelongsTo{
        return $this->belongsTo(ScholarTrain::class, 'train_id', 'id');
    }

    public function scholar_schools(){
        return $this->belongsToMany(School::class, 'scholar_school' , 'scholar_id', 'school_id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'scholar_language' , 'scholar_id', 'language_id')
        ->withPivot(
            'scholar_id',
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
