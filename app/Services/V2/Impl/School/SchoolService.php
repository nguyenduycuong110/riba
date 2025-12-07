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

    protected $with = [
        'users', 
        'school_catalogues.languages', 
        'school_projects', 
        'school_areas',
        'school_scholars.languages', 
        'languages'
    ];

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
            
            // Xử lý empty values: convert empty string thành null cho các trường nullable
            // và xử lý area_id = 0 thành null
            $nullableFields = ['code', 'rank', 'panorama', 'video', 'logo', 'address', 'phone', 'email', 'link_website', 'map'];
            foreach ($nullableFields as $field) {
                if (isset($this->modelData[$field]) && $this->modelData[$field] === '') {
                    $this->modelData[$field] = null;
                }
            }
            
            // Xử lý area_id: nếu = 0 hoặc empty thì set null
            if (isset($this->modelData['area_id']) && (empty($this->modelData['area_id']) || $this->modelData['area_id'] == 0)) {
                $this->modelData['area_id'] = null;
            }
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