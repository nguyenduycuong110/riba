<?php  
namespace App\Http\Controllers\Backend\V2\Major;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Major\MajorCatalogue\StoreRequest;
use App\Http\Requests\Major\MajorCatalogue\UpdateRequest;
use App\Services\V2\Impl\Major\MajorCatalogueService;
use App\Services\V2\Impl\Major\MajorGroupService;
use App\Models\Language;

class MajorCatalogueController extends Controller {


    private $service;
    private $majorGroupservice;
    protected $language;

    public function __construct(
        MajorCatalogueService $service,
        MajorGroupService $majorGroupservice,
    )
    {
        $this->service = $service;
        $this->majorGroupservice = $majorGroupservice;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
        $this->authorize('modules', 'major_catalogue.index');
        $majorCatalogues = $this->service->pagination($request);
        $config = [
            'model' => 'MajorCatalogue',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.major.major_catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorCatalogues'
        ));
    }

    public function create(){
        $this->authorize('modules', 'major_catalogue.create');
        $config = [
            'model' => 'MajorCatalogue',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $majorGroups = $this->majorGroupservice->convertDateSelectBox();
        $template = 'backend.major.major_catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'majorGroups'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'major_catalogue.update');
        if(!$majorCatalogue = $this->service->findById($id)){
            return redirect()->route('major.major_catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'MajorCatalogue',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $majorGroups = $this->majorGroupservice->convertDateSelectBox();
        $template = 'backend.major.major_catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorCatalogue',
            'dropdown',
            'majorGroups'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store')){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
         $this->authorize('modules', 'major_catalogue.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
         $this->authorize('modules', 'major_catalogue.destroy');
        if(!$majorCatalogue = $this->service->findById($id)){
            return redirect()->route('major_catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'MajorCatalogue',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.major.major_catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorCatalogue'
        ));
    }

    public function destroy($id){
         $this->authorize('modules', 'major_catalogue.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('major_catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý ngành',
                'table' => 'Danh sách ngành'
            ],
            'create' => [
                'title' => 'Thêm mới ngành'
            ],
            'update' => [
                'title' => 'Cập nhật ngành'
            ],
            'delete' => [
                'title' => 'Xóa ngành'
            ]
        ];
    }

}