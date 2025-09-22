<?php  
namespace App\Http\Controllers\Backend\V2\School;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\School\Project\StoreRequest;
use App\Http\Requests\School\Project\UpdateRequest;
use App\Services\V2\Impl\School\ProjectService;
use App\Models\Language;

class ProjectController extends Controller {

    private $service;

    protected $language;

    public function __construct(
        ProjectService $service
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
        $this->authorize('modules', 'project.index');
        $records = $this->service->pagination($request);
        $config = [
            ...$this->config(),
            'extendJs' => true
        ];
        $template = 'backend.school.project.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'records'
        ));
    }

    public function create(){
        $this->authorize('modules', 'project.create');
        $config = [
            ...$this->config(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.school.project.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'project.update');
        if(!$record = $this->service->findById($id)){
            return redirect()->route('school.project.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            ...$this->config(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.school.project.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'record'
        ));     
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('modules', 'project.create');
        $response = $this->service->save($request, 'store');
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.project.index');
    }


    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'project.update');
        $response = $this->service->save($request, 'update', $id);
        return $this->handleActionResponse($response, $request, redirectRoute: 'school.project.index');
    }

    public function delete($id){
        $this->authorize('modules', 'project.destroy');
        $record = $this->service->findById($id);
        $this->checkExists($record);
        $config = [
            ...$this->config(),
            'method' => 'update'
        ];
        $template = 'backend.school.project.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'record'
        ));
    }

    public function destroy($id, Request $request){
        $this->authorize('modules', 'project.destroy');
        $response = $this->service->destroy($id);
        return $this->handleActionResponse($response, $request, message: 'Xóa bản ghi thành công', redirectRoute: 'school.project.index');
        
    }

    private function config(): array{
        return $config = [
            'model' => 'Project',
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