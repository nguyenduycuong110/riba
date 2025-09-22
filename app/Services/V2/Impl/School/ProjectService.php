<?php  
namespace App\Services\V2\Impl\School;
use App\Services\V2\BaseService;
use App\Repositories\School\ProjectRepo;
use Illuminate\Support\Facades\Auth;

class ProjectService extends BaseService {

    protected $repository;

    protected $fillable;

    protected $with = ['users'];

    public function __construct(
        ProjectRepo $repository,
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


}