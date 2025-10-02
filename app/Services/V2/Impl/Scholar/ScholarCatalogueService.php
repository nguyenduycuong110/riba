<?php  
namespace App\Services\V2\Impl\Scholar;
use App\Services\V2\BaseService;
use App\Repositories\Scholar\ScholarCatalogueRepo;
use Illuminate\Support\Facades\Auth;
use App\Classes\Nestedsetbie;
use App\Traits\HasNested;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;
use Illuminate\Http\Request;

class ScholarCatalogueService extends BaseService {

    use HasNested, HasRouter;
    
    protected $repository;
    
    protected $fillable;

    protected $nestedset;

    private $routerService;

    protected $with = ['languages', 'users'];
    protected $simpleFilter = ['publish', 'level'];
    protected $complexFilters = ['lft', 'rgt'];

    public function __construct(
        ScholarCatalogueRepo $repository,
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

    public function dropdown(){
        $this->initNestedset(table: 'scholar_catalogues', key: 'scholar_catalogue_id'); 
        return $this->nestedset->Dropdown();
    }

    protected function beforeSave(): static {
        $this->generatePayloadLanguage();
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'ScholarCatalogueController');
        $this->initNestedset(table: 'scholar_catalogues', key: 'scholar_catalogue_id'); 
        $this->nestedSet();
        return $this;
    }

}