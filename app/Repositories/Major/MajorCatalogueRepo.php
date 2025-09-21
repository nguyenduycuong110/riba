<?php  
namespace App\Repositories\Major;
use App\Models\Major;
use App\Repositories\BaseRepository;

class MajorCatalogueRepo  extends BaseRepository{

    protected $model;

    public function __construct(
        MajorCatalogue $model
    )
    {
        $this->model = $model;
        parent::__construct($model);
    }
}