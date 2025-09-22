<?php  
namespace App\Http\Controllers\Backend\V2\School;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\School\SchoolCatalogue\StoreRequest;
use App\Http\Requests\School\SchoolCatalogue\UpdateRequest;
use App\Services\V2\Impl\School\SchoolCatalogueService;
use App\Models\Language;

class SchoolCatalogueController extends Controller {

    private $service;
    protected $language;

    public function __construct(
        SchoolCatalogueService $service
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
        $this->authorize('modules', 'school_catalogue.index');
        $schoolCatalogues = $this->service->pagination($request);
        $config = [
            'model' => 'SchoolCatalogue',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.school.school_catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogues'
        ));
    }

    public function create(){
        $this->authorize('modules', 'school_catalogue.create');
        $config = [
            'model' => 'SchoolCatalogue',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.school.school_catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'school_catalogue.update');
        if(!$schoolCatalogue = $this->service->findById($id)){
            return redirect()->route('school.school_catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'SchoolCatalogue',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.school.school_catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogue',
            'dropdown'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store')){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'school_catalogue.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'school_catalogue.destroy');
        if(!$schoolCatalogue = $this->service->findById($id)){
            return redirect()->route('school_catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'SchoolCatalogue',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.school.school_catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogue'
        ));
    }

    public function destroy($id){
        $this->authorize('modules', 'school_catalogue.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('school_catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý loại hình trường',
                'table' => 'Danh sách loại hình trường'
            ],
            'create' => [
                'title' => 'Thêm mới loại hình trường'
            ],
            'update' => [
                'title' => 'Cập nhật loại hình trường'
            ],
            'delete' => [
                'title' => 'Xóa loại hình trường'
            ]
        ];
    }

}