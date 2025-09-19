<?php  
namespace App\Services\V2\Impl\Scholar;
use App\Services\V2\BaseService;
use App\Repositories\Scholar\PolicyRepo;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasNested;
use App\Traits\HasRouter;

class PolicyService extends BaseService {

    use HasNested, HasRouter;
    
    protected $repository;
    protected $fillable;

    protected $nestedset;

    public function __construct(
        PolicyRepo $repository,
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