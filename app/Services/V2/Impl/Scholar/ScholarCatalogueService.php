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

    public function __construct(
        ScholarCatalogueRepo $repository,
        RouterService $routerService
    )
    {
        $this->repository = $repository;
        $this->routerService = $routerService;
    }

    private function initNestedset($languageId){
        $this->nestedset = new Nestedsetbie([
            'table' => 'scholar_catalogues',
            'foreignkey' => 'scholar_catalogue_id',
            'language_id' =>  $languageId ,
        ]);
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

    public function dropdown($languageId){
        $this->initNestedset($languageId);
        return $this->nestedset->Dropdown();
    }

    protected function beforeSave(): static {
        $this->generatePayloadLanguage();
        return $this;
    }

    protected function afterSave(): static {
        $request = $this->context['request'];
        $languageId = $this->context['languageId'];
        $payload = $this->createRouterPayload($request->canonical, $this->model->id, $languageId, 'ScholarCatalogueController');
        $routerRequest = new Request();
        $routerRequest->merge($payload);
        $this->routerService->save($routerRequest, 'store');
        $this->initNestedset($this->context['languageId']);
        $this->nestedSet();
        return $this;
    }

}