<?php  
namespace App\Http\Controllers\Backend\V2\Scholar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Scholar\Catalogue\StoreRequest;
use App\Http\Requests\Scholar\Catalogue\UpdateRequest;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Models\Language;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\ScholarCatalogueResource;

class ScholarCatalogueController extends Controller {


    private $service;
    protected $language;

    public function __construct(
        ScholarCatalogueService $service
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
        $scholars = $this->service->pagination($request);
        $config = [
            'model' => 'ScholarCatalogue',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.scholar.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholars'
        ));
    }

    public function create(){
         // $this->authorize('modules', 'scholar.option.catalogue.create');
        $config = [
            'model' => 'ScholarCatalogue',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.scholar.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'scholar.option.catalogue.update');
        if(!$scholar = $this->service->findById($id)){
            return redirect()->route('scholar.catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'ScholarCatalogue',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.scholar.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholar',
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
         // $this->authorize('modules', 'scholar.option.catalogue.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'scholar.option.catalogue.destroy');
        if(!$scholar = $this->service->findById($id)){
            return redirect()->route('scholar.catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'ScholarCatalogue',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.scholar.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholar'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'scholar.option.catalogue.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('scholar.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý loại học bổng',
                'table' => 'Danh sách loại học bổng'
            ],
            'create' => [
                'title' => 'Thêm mới loại học bổng'
            ],
            'update' => [
                'title' => 'Cập nhật loại học bổng'
            ],
            'delete' => [
                'title' => 'Xóa loại học bổng'
            ]
        ];
    }

}