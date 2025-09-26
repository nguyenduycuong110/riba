<?php  
namespace App\Services\V2\Impl\School;
use App\Services\V2\BaseService;
use App\Repositories\School\SchoolRepo;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;

class SchoolService extends BaseService {

    use HasRouter;
    
    protected $repository;
    protected $fillable;
    private $routerService;

    protected $with = ['users', 'school_catalogues', 'school_projects', 'school_areas', 'languages'];

    public function __construct(
        SchoolRepo $repository,
        RouterService $routerService
    )
    {
        $this->repository = $repository;
        $this->routerService = $routerService;
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
        $this->generatePayloadLanguage();
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'SchoolController');
        return $this;
    }

}