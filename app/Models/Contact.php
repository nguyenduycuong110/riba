<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryScopes;

class Contact extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        // Bang contacts co cot email va form lien he bat buoc nhap, nhung truoc
        // day cot nay khong nam trong fillable nen Contact::create() lang le bo
        // di - luu xong van khong co email de lien he lai.
        'email',
        'address',
        'product_id',
        'post_id',
        'publish',
        'created_at',
        'type',
        'message'
    ];

    protected $table = 'contacts';

    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function posts(){
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

}