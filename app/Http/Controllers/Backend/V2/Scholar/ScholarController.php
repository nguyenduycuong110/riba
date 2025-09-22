<?php  
namespace App\Http\Controllers\Backend\V2\Scholar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Scholar\Scholar\StoreRequest;
use App\Http\Requests\Scholar\Scholar\UpdateRequest;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V2\Impl\Scholar\ScholarCatalogueService;
use App\Services\V2\Impl\Scholar\PolicyService;
use App\Services\V2\Impl\Scholar\TrainService;
use App\Services\V2\Impl\School\SchoolService;
use App\Models\Language;

class ScholarController extends Controller {


    private $service;
    private $scholarCatalogueService;
    private $policyService;
    private $trainService;
    private $schoolService;
    protected $language;

    public function __construct(
        ScholarService $service,
        ScholarCatalogueService $scholarCatalogueService,
        PolicyService $policyService,
        TrainService $trainService,
        SchoolService $schoolService
    )
    {
        $this->service = $service;
        $this->scholarCatalogueService = $scholarCatalogueService;
        $this->policyService = $policyService;
        $this->trainService = $trainService;
        $this->schoolService = $schoolService;
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
            'model' => 'Scholar',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.scholar.scholar.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholars'
        ));
    }

    public function create(){
        // $this->authorize('modules', 'scholar.option.scholar.create');
        $dropdown = $this->scholarCatalogueService->dropdown();
        $policies = $this->policyService->all()->pluck('name', 'id');
        $trains = $this->trainService->all()->pluck('name', 'id');
        $schools = $this->schoolService->convertDateSelectBox();
        $config = [
            'model' => 'Scholar',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.scholar.scholar.store';
        return view('backend.dashboard.layout', compact(
            'dropdown',
            'policies',
            'trains',
            'schools',
            'template',
            'config',
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'scholar.option.scholar.update');
        if(!$scholar = $this->service->findById($id)){
            return redirect()->route('scholar.index')->with('error','Bản ghi không tồn tại'); 
        }
        $dropdown = $this->scholarCatalogueService->dropdown();
        $policies = $this->policyService->all()->pluck('name', 'id');
        $trains = $this->trainService->all()->pluck('name', 'id');
        $schools = $this->schoolService->convertDateSelectBox();
        $config = [
            'model' => 'Scholar',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.scholar.scholar.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholar',
            'dropdown',
            'policies',
            'trains',
            'schools'
        ));     
    }
    
    public function store(StoreRequest $request)
    {
        $response = $this->service->save($request, 'store');
        if ($response) {
            if ($request->input('send') == 'send_and_stay') {
                return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
            }
            return redirect()->route('scholar.index')->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }


    public function update($id, UpdateRequest $request){
         // $this->authorize('modules', 'scholar.option.scholar.update');
        $response = $this->service->save($request, 'update', $id);
        if($response){
            if ($request->input('send') == 'send_and_stay') {
                return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
            }
            return redirect()->route('scholar.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'scholar.option.scholar.destroy');
        if(!$scholar = $this->service->findById($id)){
            return redirect()->route('scholar.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Scholar',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.scholar.scholar.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholar'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'scholar.option..destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('scholar.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý học bổng',
                'table' => 'Danh sách học bổng'
            ],
            'create' => [
                'title' => 'Thêm mới học bổng'
            ],
            'update' => [
                'title' => 'Cập nhật học bổng'
            ],
            'delete' => [
                'title' => 'Xóa học bổng'
            ]
        ];
    }

}