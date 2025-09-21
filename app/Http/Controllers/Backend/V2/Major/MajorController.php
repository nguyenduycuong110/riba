<?php  
namespace App\Http\Controllers\Backend\V2\Major;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Major\Major\StoreRequest;
use App\Http\Requests\Major\Major\UpdateRequest;
use App\Services\V2\Impl\Major\MajorService;
use App\Models\Language;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\MajorResource;
use App\Services\V2\Impl\Major\MajorCatalogueService;

class MajorController extends Controller {


    private $service;
    private $majorCatalogueService;
    protected $language;

    public function __construct(
        MajorService $service,
        MajorCatalogueService $majorCatalogueService
    )
    {
        $this->service = $service;
        $this->majorCatalogueService = $majorCatalogueService;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
         // $this->authorize('modules', 'major.major.index');
        $majors = $this->service->pagination($request);
        $config = [
            'model' => 'Major',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.major.major.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majors'
        ));
    }

    public function create(){
         // $this->authorize('modules', 'major.major.create');
        $config = [
            'model' => 'Major',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->majorCatalogueService->dropdown();
        $template = 'backend.major.major.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'major.major.update');
        if(!$major = $this->service->findById($id)){
            return redirect()->route('major.major.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Major',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->majorCatalogueService->dropdown();
        $template = 'backend.major.major.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'major',
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
         // $this->authorize('modules', 'major.major.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'major.major.destroy');
        if(!$major = $this->service->findById($id)){
            return redirect()->route('major.major.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Major',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.major.major.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'major'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'major.major.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('major.major.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý Chuyên Ngành',
                'table' => 'Danh sách Chuyên Ngành'
            ],
            'create' => [
                'title' => 'Thêm mới Chuyên Ngành'
            ],
            'update' => [
                'title' => 'Cập nhật Chuyên Ngành'
            ],
            'delete' => [
                'title' => 'Xóa Chuyên Ngành'
            ]
        ];
    }

}