<?php

namespace App\Repositories\Post;

use App\Models\PostCatalogue;
use App\Repositories\BaseRepository;


/**
 * Class UserService
 * @package App\Services
 */
class PostCatalogueRepository extends BaseRepository
{
    protected $model;

    public function __construct(
        PostCatalogue $model
    ){
        $this->model = $model;
        parent::__construct($model);
    }

    

    public function getPostCatalogueById(int $id = 0, $language_id = 0){
        return $this->model->select([
                'post_catalogues.id',
                'post_catalogues.parent_id',
                'post_catalogues.image',
                'post_catalogues.icon',
                'post_catalogues.album',
                'post_catalogues.publish',
                'post_catalogues.follow',
                'post_catalogues.lft',
                'post_catalogues.rgt',
                'post_catalogues.created_at',
                'post_catalogues.short_name',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=','post_catalogues.id')
        ->where('tb2.language_id', '=', $language_id)
        ->with(['direct_children.languages', 'direct_children.posts'])
        ->find($id);
    }

    public function getFeaturedPost($postCatalogue, $languageId){
        return \App\Models\Post::select([
                'posts.id',
                'posts.image',
                'posts.created_at',
                'posts.recommend',
                'tb2.name',
                'tb2.description',
                'tb2.canonical',
            ])
            ->join('post_language as tb2', 'tb2.post_id', '=', 'posts.id')
            ->join('post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id')
            ->where('tb2.language_id', '=', $languageId)
            ->where('posts.publish', '=', 2)
            ->where('posts.recommend', '=', 2)
            ->whereRaw('tb3.post_catalogue_id IN (
                SELECT id
                FROM post_catalogues
                WHERE lft >= ? AND rgt <= ?
            )', [$postCatalogue->lft, $postCatalogue->rgt])
            ->orderBy('posts.order', 'desc')
            ->orderBy('posts.id', 'desc')
            ->distinct()
            ->get();
    }

}
