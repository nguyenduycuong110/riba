<?php  
namespace App\Services\V2\Impl\Scholar;
use App\Services\V2\BaseService;
use App\Repositories\Scholar\TrainRepo;
use Illuminate\Support\Facades\Auth;

class TrainService extends BaseService {

    protected $repository;

    protected $fillable;

    protected $with = ['users'];

    public function __construct(
        TrainRepo $repository,
    )
    {
        $this->repository = $repository;
    }

    public function prepareModelData(): static {
        $request = $this->context['request'] ?? null;
        if(!is_null($request)){
            $this->fillable = $this->repository->getFillable();
            $this->modelData = $request->only($this->fillable);
            $this->modelData['user_id'] = Auth::id();
        }
        return $this;
    }

    protected function beforeSave(): static {
        return $this;
    }

    protected function afterSave(): static {
        return $this;
    }

}