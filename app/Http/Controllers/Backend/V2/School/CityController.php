<?php  
namespace App\Http\Controllers\Backend\V2\School;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\School\City\StoreRequest;
use App\Http\Requests\School\City\UpdateRequest;
use App\Services\V2\Impl\School\CityService;
use App\Services\V2\Impl\School\AreaService;
use App\Models\Language;

class CityController extends Controller {

    private $service;

    private $areaService;

    protected $language;

    public function __construct(
        CityService $service,
        AreaService $areaService,
    )
    {
        $this->service = $service;
        $this->areaService = $areaService;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
        $this->authorize('modules', 'city.index');
        $records = $this->service->pagination($request);
        $config = [
            ...$this->config(),
            'extendJs' => true
        ];
        $template = 'backend.school.city.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'records'
        ));
    }

    public function create(){
        $this->authorize('modules', 'city.create');
        $areas = $this->areaService->all()->pluck('name', 'id');
        $config = [
            ...$this->config(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.school.city.store';
        return view('backend.dashboard.layout', compact(
            'areas',
            'template',
            'config'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'city.update');
        if(!$record = $this->service->findById($id)){
            return redirect()->route('school.city.index')->with('error','Bản ghi không tồn tại'); 
        }
        $areas = $this->areaService->all()->pluck('name', 'id');
        $config = [
            ...$this->config(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.school.city.store';
        return view('backend.dashboard.layout', compact(
            'areas',
            'template',
            'config',
            'record'
        ));     
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('modules', 'city.create');
        $response = $this->service->save($request, 'store');
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.city.index');
    }


    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'city.update');
        $response = $this->service->save($request, 'update', $id);
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.city.index');
    }

    public function delete($id){
        $this->authorize('modules', 'city.destroy');
        $record = $this->service->findById($id);
        $this->checkExists($record);
        $config = [
            ...$this->config(),
            'method' => 'update'
        ];
        $template = 'backend.school.city.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'record'
        ));
    }

    public function destroy($id, Request $request){
        $this->authorize('modules', 'city.destroy');
        $response = $this->service->destroy($id);
        return $this->handleActionResponse($response, $request, message: 'Xóa bản ghi thành công', redirectRoute: 'school.city.index');
        
    }

    private function config(): array{
        return $config = [
            'model' => 'City',
            'seo' => $this->seo()
        ];
    }

    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý thành phố',
                'table' => 'Danh sách thành phố'
            ],
            'create' => [
                'title' => 'Thêm mới thành phố'
            ],
            'update' => [
                'title' => 'Cập nhật thành phố'
            ],
            'delete' => [
                'title' => 'Xóa thành phố'
            ]
        ];
    }

}