<?php  
namespace App\Services\V2\Impl\Major;
use App\Services\V2\BaseService;
use App\Repositories\Major\MajorRepo;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasRouter;
use App\Services\V2\Impl\RouterService;

class MajorService extends BaseService {

    use HasRouter;
    
    protected $repository;
    protected $fillable;
    private $routerService;

    protected $with = ['languages', 'users', 'major_groups.languages'];

    public function __construct(
        MajorRepo $repository,
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
            
            // Xử lý empty values: convert empty string thành null cho các trường nullable
            $nullableFields = ['en_name', 'cn_name', 'code'];
            foreach ($nullableFields as $field) {
                if (isset($this->modelData[$field]) && $this->modelData[$field] === '') {
                    $this->modelData[$field] = null;
                }
            }
            
            // Xử lý total_applications: nếu empty hoặc null thì set default 0
            if (!isset($this->modelData['total_applications']) || 
                $this->modelData['total_applications'] === '' || 
                $this->modelData['total_applications'] === null) {
                $this->modelData['total_applications'] = 0;
            }
        }
        return $this;
    }


    protected function beforeSave(): static {
        $request = $this->context['request'] ?? null;
        $this->generatePayloadLanguage();
        $this->generatePayloadRelation('major_catalogues', [$request->input('major_catalogue_id')]);
        return $this;
    }

    protected function afterSave(): static {
        $this->handleRouter(controller: 'MajorController');
        return $this;
    }

}