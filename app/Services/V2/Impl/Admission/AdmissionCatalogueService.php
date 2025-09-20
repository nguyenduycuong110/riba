<?php  
namespace App\Services\V2\Impl\Admission;
use App\Services\V2\BaseService;
use App\Repositories\Admission\AdmissionCatalogueRepo;
use Illuminate\Support\Facades\Auth;
use App\Classes\Nestedsetbie;
use App\Traits\HasNested;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;
use Illuminate\Http\Request;

class AdmissionCatalogueService extends BaseService {

    use HasNested, HasRouter;
    
    protected $repository;
    
    protected $fillable;

    protected $nestedset;

    private $routerService;

    protected $with = ['languages', 'users'];

    public function __construct(
        AdmissionCatalogueRepo $repository,
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
        $this->initNestedset(table: 'admission_catalogues', key: 'admission_catalogue_id'); 
        return $this->nestedset->Dropdown();
    }

    protected function beforeSave(): static {
        $this->generatePayloadLanguage();
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'AdmissionCatalogueController');
        $this->initNestedset(table: 'admission_catalogues', key: 'admission_catalogue_id'); 
        $this->nestedSet();
        return $this;
    }

}