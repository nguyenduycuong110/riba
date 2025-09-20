<?php  
namespace App\Services\V2\Impl\Admission;
use App\Services\V2\BaseService;
use App\Repositories\Admission\AdmissionRepo;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;

class AdmissionService extends BaseService {

    use HasRouter;
    
    protected $repository;

    protected $fillable;

    private $routerService;

    protected $with = ['languages', 'users', 'admission_trains'];

    public function __construct(
        AdmissionRepo $repository,
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
            $this->modelData['submission_time'] = $request->admissions_info['apply_deadline'];
            $this->modelData['user_id'] = Auth::id();
        }
        return $this;
    }

    protected function beforeSave(): static {
        $this->generatePayloadLanguage();
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'AdmissionController');
        return $this;
    }

}