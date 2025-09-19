<?php   
namespace App\Repositories\Scholar;
use App\Repositories\BaseRepository;

use App\Models\Policy;

class PolicyRepo extends BaseRepository {
    protected $model;

    public function __construct(
        Policy $model
    )
    {
        $this->model = $model;
    }

}