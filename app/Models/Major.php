<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use App\Traits\HasQuery;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Major extends Model
{
   use HasFactory, SoftDeletes, HasQuery;

    protected $fillable = [
        'total_applications',
        'image',
        'album',
        'publish',
        'follow',
        'order',
        'user_id',
        'train_id',
        'viewed',
    ];

    protected $casts = [
        'album' => 'json',
    ];

    protected $table = 'majors';

    protected $with = ['major_catalogues'];

    protected $relationable = [
       'languages', 'major_catalogues' , 'major_trains'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function major_trains(): BelongsTo{
        return $this->belongsTo(ScholarTrain::class, 'train_id', 'id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'major_language' , 'major_id', 'language_id')
        ->withPivot(
            'major_id',
            'language_id',
            'name',
            'canonical',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description',
            'content'
        );
    }

    public function major_catalogues(){
        return $this->belongsToMany(MajorCatalogue::class, 'major_catalogue_major' , 'major_id', 'major_catalogue_id');
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
