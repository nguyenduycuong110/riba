<?php  
namespace App\Http\Controllers\Backend\V2\School;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\School\Area\StoreRequest;
use App\Http\Requests\School\Area\UpdateRequest;
use App\Services\V2\Impl\School\AreaService;
use App\Models\Language;

class AreaController extends Controller {

    private $service;

    protected $language;

    public function __construct(
        AreaService $service
    )
    {
        $this->service = $service;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
        $this->authorize('modules', 'area.index');
        $records = $this->service->pagination($request);
        $config = [
            ...$this->config(),
            'extendJs' => true
        ];
        $template = 'backend.school.area.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'records'
        ));
    }

    public function create(){
        $this->authorize('modules', 'area.create');
        $config = [
            ...$this->config(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.school.area.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'area.update');
        if(!$record = $this->service->findById($id)){
            return redirect()->route('school.area.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            ...$this->config(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.school.area.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'record'
        ));     
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('modules', 'area.create');
        $response = $this->service->save($request, 'store');
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.area.index');
    }


    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'area.update');
        $response = $this->service->save($request, 'update', $id);
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.area.index');
    }

    public function delete($id){
        $this->authorize('modules', 'area.destroy');
        $record = $this->service->findById($id);
        $this->checkExists($record);
        $config = [
            ...$this->config(),
            'method' => 'update'
        ];
        $template = 'backend.school.area.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'record'
        ));
    }

    public function destroy($id, Request $request){
        $this->authorize('modules', 'area.destroy');
        $response = $this->service->destroy($id);
        return $this->handleActionResponse($response, $request, message: 'Xóa bản ghi thành công', redirectRoute: 'school.area.index');
        
    }

    private function config(): array{
        return $config = [
            'model' => 'SchoolArea',
            'seo' => $this->seo()
        ];
    }

    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý khu vực',
                'table' => 'Danh sách khu vực'
            ],
            'create' => [
                'title' => 'Thêm mới khu vực'
            ],
            'update' => [
                'title' => 'Cập nhật khu vực'
            ],
            'delete' => [
                'title' => 'Xóa khu vực'
            ]
        ];
    }

}