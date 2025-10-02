<?php  
namespace App\Services\V2\Impl\Scholar;
use App\Services\V2\BaseService;
use App\Repositories\Scholar\ScholarRepo;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;
use Illuminate\Http\Request;

class ScholarService extends BaseService {

    use HasRouter;
    
    protected $repository;
    protected $fillable;
    private $routerService;

    protected $with = ['languages', 'users'];
    protected $perpage = 24;

    public function __construct(
        ScholarRepo $repository,
        RouterService $routerService
    )
    {
        $this->repository = $repository;
        $this->routerService = $routerService;
        // Lazy load nestedset
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
        $request = $this->context['request'] ?? null;
        $this->generatePayloadLanguage();
        $this->generatePayloadRelation('scholar_catalogues', [$request->input('scholar_catalogue_id')]);
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'ScholarController');
        return $this;
    }

    protected function specifications(Request $request): array
    {
        $specs = parent::specifications($request);
        if($request->has('scholar_catalogue_id')){
            $specs['filter']['relation'][0]['name'] = 'scholar_catalogues';
            $specs['filter']['relation'][0]['id'] =  $request->childrenId;
            $specs['filter']['relation'][0]['field'] = 'scholar_catalogue_id';
        }
        if($request->has('path')){
            $specs['path'] = $request->path;
        }

        return $specs;
    }

}

