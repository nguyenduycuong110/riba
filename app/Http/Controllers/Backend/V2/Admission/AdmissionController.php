<?php  
namespace App\Http\Controllers\Backend\V2\Admission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admission\Admission\StoreRequest;
use App\Http\Requests\Admission\Admission\UpdateRequest;
use App\Services\V2\Impl\Admission\AdmissionService;
use App\Services\V2\Impl\Admission\AdmissionCatalogueService;
use App\Services\V2\Impl\Scholar\ScholarService;
use App\Services\V2\Impl\Scholar\TrainService;
use App\Services\V2\Impl\School\SchoolService;
use App\Models\Language;

class AdmissionController extends Controller {

    private $service;
    private $admissionCatalogueservice;
    private $scholarService;
    private $trainService;
    private $schoolService;
    protected $language;

    public function __construct(
        AdmissionService $service,
        AdmissionCatalogueService $admissionCatalogueservice,
        ScholarService $scholarService,
        TrainService $trainService,
        SchoolService $schoolService
    )
    {
        $this->service = $service;
        $this->admissionCatalogueservice = $admissionCatalogueservice;
        $this->scholarService = $scholarService;
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
        $admissions = $this->service->pagination($request);
        $config = [
            'model' => 'Admission',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.admission.admission.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'admissions'
        ));
    }

    public function create(){
        // $this->authorize('modules', 'admission.option.admission.create');
        $dropdown = $this->admissionCatalogueservice->dropdown();
        $scholars = $this->scholarService->convertDateSelectBox();
        $trains = $this->trainService->all()->pluck('name', 'id');
        $schools = $this->schoolService->convertDateSelectBox();
        $config = [
            'model' => 'Admission',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.admission.admission.store';
        return view('backend.dashboard.layout', compact(
            'dropdown',
            'scholars',
            'trains',
            'schools',
            'template',
            'config',
        ));
    }

    public function edit($id){
        // $this->authorize('modules', 'admission.option.admission.update');
        if(!$admission = $this->service->findById($id)){
            return redirect()->route('admission.index')->with('error','Bản ghi không tồn tại'); 
        }
        $dropdown = $this->admissionCatalogueservice->dropdown();
        $scholars = $this->scholarService->convertDateSelectBox();
        $trains = $this->trainService->all()->pluck('name', 'id');
        $schools = $this->schoolService->convertDateSelectBox();
        $config = [
            'model' => 'Admission',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.admission.admission.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'admission',
            'scholars',
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
            return redirect()->route('admission.index')->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
         // $this->authorize('modules', 'admission.option.admission.update');
        $response = $this->service->save($request, 'update', $id);
        if($response){
            if ($request->input('send') == 'send_and_stay') {
                return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
            }
            return redirect()->route('admission.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'admission.option.admission.destroy');
        if(!$admission = $this->service->findById($id)){
            return redirect()->route('admission.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Admission',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.admission.admission.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'admission'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'admission.option.admission.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('admission.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý tuyển sinh',
                'table' => 'Danh sách tuyển sinh'
            ],
            'create' => [
                'title' => 'Thêm mới tuyển sinh'
            ],
            'update' => [
                'title' => 'Cập nhật tuyển sinh'
            ],
            'delete' => [
                'title' => 'Xóa tuyển sinh'
            ]
        ];
    }

}