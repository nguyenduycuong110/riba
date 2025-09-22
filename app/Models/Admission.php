<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;

class Admission extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $languageId;

    protected $fillable = [
        'id',
        'admissions_info',
        'submission_time',
        'admission_catalogue_id',
        'scholar_id',
        'image',
        'album',
        'publish',
        'order',
        'user_id',
    ];

    protected $casts = [
        'album' => 'json',
        'admissions_info' => 'json'
    ];

    protected $relationable = [
        'users', 'admission_catalogues', 'admission_schools', 'admission_trains', 'scholars', 'languages'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admission_catalogues(): BelongsTo{
        return $this->belongsTo(ScholarCatalogue::class, 'admission_catalogue_id', 'id');
    }

    public function scholars(): BelongsTo{
        return $this->belongsTo(Scholar::class, 'scholar_id', 'id');
    }

    public function admission_trains(){
        return $this->belongsToMany(ScholarTrain::class, 'admission_train', 'admission_id', 'train_id');
    }

    public function admission_schools(){
        return $this->belongsToMany(School::class, 'admission_school', 'admission_id', 'school_id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'admission_language' , 'admission_id', 'language_id')
        ->withPivot(
            'admission_id',
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
