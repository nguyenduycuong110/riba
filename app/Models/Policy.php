<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasQuery;

class Policy extends Model
{
    use HasQuery;

    protected $fillable = [
        'id',
        'name',
        'publish'
    ];

    protected $table = 'scholar_policies';

    protected $relationable = [];

    public function getRelationable(){
        return $this->relationable;
    }

}
