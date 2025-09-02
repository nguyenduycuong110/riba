<?php

namespace App\Repositories;

use App\Models\Introduce;
use App\Repositories\Interfaces\IntroduceRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class IntroduceRepository extends BaseRepository implements IntroduceRepositoryInterface
{
    protected $model;

    public function __construct(
        Introduce $model
    ){
        $this->model = $model;
    }


}
