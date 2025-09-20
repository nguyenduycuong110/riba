<?php  
namespace App\Http\Controllers\Backend\V2\Admission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admission\Catalogue\StoreRequest;
use App\Http\Requests\Admission\Catalogue\UpdateRequest;
use App\Services\V2\Impl\Admission\AdmissionCatalogueService;
use App\Models\Language;

class AdmissionCatalogueController extends Controller {

    private $service;

    protected $language;

    public function __construct(
        AdmissionCatalogueService $service
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
        $admissions = $this->service->pagination($request);
        $config = [
            'model' => 'AdmissionCatalogue',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.admission.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'admissions'
        ));
    }

    public function create(){
         // $this->authorize('modules', 'admission.option.catalogue.create');
        $config = [
            'model' => 'AdmissionCatalogue',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.admission.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'admission.option.catalogue.update');
        if(!$admission = $this->service->findById($id)){
            return redirect()->route('admission.catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'AdmissionCatalogue',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.admission.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'admission',
            'dropdown'
        ));     
    }

    public function store(StoreRequest $request)
    {
        $response = $this->service->save($request, 'store');
        if ($response) {
            if ($request->input('send') == 'send_and_stay') {
                return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
            }
            return redirect()->route('admission.catalogue.index')->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }


    public function update($id, UpdateRequest $request){
         // $this->authorize('modules', 'admission.option.catalogue.update');
        $response = $this->service->save($request, 'update', $id);
        if($response){
            if ($request->input('send') == 'send_and_stay') {
                return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
            }
            return redirect()->route('admission.catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'admission.option.catalogue.destroy');
        if(!$admission = $this->service->findById($id)){
            return redirect()->route('admission.catalogue.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'AdmissionCatalogue',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.admission.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'admission'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'admission.option.catalogue.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('admission.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý loại tuyển sinh',
                'table' => 'Danh sách loại tuyển sinh'
            ],
            'create' => [
                'title' => 'Thêm mới loại tuyển sinh'
            ],
            'update' => [
                'title' => 'Cập nhật loại tuyển sinh'
            ],
            'delete' => [
                'title' => 'Xóa loại tuyển sinh'
            ]
        ];
    }

}