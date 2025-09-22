<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasQuery;

class MajorCatalogue extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $languageId;

    protected $fillable = [
        'id',
        'major_group_id',
        'code',
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
    ];

    protected $casts = [
        'album' => 'json'
    ];

    protected $relationable = [
        'users', 'major_groups', 'languages'
    ];

    public function getRelationable(){
        return $this->relationable;
    }

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function major_groups(): BelongsTo{
        return $this->belongsTo(MajorGroup::class, 'major_group_id', 'id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'major_catalogue_language' , 'major_catalogue_id', 'language_id')
        ->withPivot(
            'major_catalogue_id',
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
   

}
