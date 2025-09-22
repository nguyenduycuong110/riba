<?php  
namespace App\Http\Controllers\Backend\V2\School;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\School\School\StoreRequest;
use App\Http\Requests\School\School\UpdateRequest;
use App\Services\V2\Impl\School\SchoolService;
use App\Services\V2\Impl\School\SchoolCatalogueService;
use App\Services\V2\Impl\School\ProjectService;
use App\Services\V2\Impl\School\AreaService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V1\Post\PostService;
use App\Models\Language;

class SchoolController extends Controller {


    private $service;
    private $schoolCatalogueService;
    private $projectService;
    private $scholarService;
    private $postService;
    private $areaService;
    protected $language;

    public function __construct(
        SchoolService $service,
        SchoolCatalogueService $schoolCatalogueService,
        ProjectService $projectService,
        ScholarService $scholarService,
        PostService $postService,
        AreaService $areaService,
    )
    {
        $this->service = $service;
        $this->schoolCatalogueService = $schoolCatalogueService;
        $this->projectService = $projectService;
        $this->scholarService = $scholarService;
        $this->postService = $postService;
        $this->areaService = $areaService;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
        $this->authorize('modules', 'school.index');
        $schools = $this->service->pagination($request);
        $config = [
            'model' => 'School',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.school.school.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schools'
        ));
    }

    public function create(){
        $this->authorize('modules', 'school.create');
        $schoolCatalogues = $this->schoolCatalogueService->convertDateSelectBox();
        $projects = $this->projectService->all()->pluck('name', 'id');
        $areas = $this->areaService->all()->pluck('name', 'id');
        $scholars = $this->scholarService->convertDateSelectBox();
        $posts = $this->postService->convertDateSelectBox();
        $config = [
            'model' => 'School',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.school.school.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogues',
            'projects',
            'scholars',
            'posts',
            'areas'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'school.update');
        if(!$school = $this->service->findById($id)){
            return redirect()->route('school.school.index')->with('error','Bản ghi không tồn tại'); 
        }
        $schoolCatalogues = $this->schoolCatalogueService->convertDateSelectBox();
        $projects = $this->projectService->all()->pluck('name', 'id');
        $areas = $this->areaService->all()->pluck('name', 'id');
        $scholars = $this->scholarService->convertDateSelectBox();
        $posts = $this->postService->convertDateSelectBox();
        $config = [
            'model' => 'School',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.school.school.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'school',
            'schoolCatalogues',
            'projects',
            'scholars',
            'posts',
            'areas'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store')){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'school.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'school.destroy');
        if(!$school = $this->service->findById($id)){
            return redirect()->route('school.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'School',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.school.school.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'school'
        ));
    }

    public function destroy($id){
        $this->authorize('modules', 'school.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('school.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý trường',
                'table' => 'Danh sách trường'
            ],
            'create' => [
                'title' => 'Thêm mới trường'
            ],
            'update' => [
                'title' => 'Cập nhật trường'
            ],
            'delete' => [
                'title' => 'Xóa trường'
            ]
        ];
    }

}