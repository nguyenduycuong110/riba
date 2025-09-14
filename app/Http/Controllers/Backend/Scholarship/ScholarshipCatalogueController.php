<?php

namespace App\Http\Controllers\Backend\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ScholarshipCatalogueServiceInterface  as ScholarshipCatalogueService;
use App\Repositories\Interfaces\ScholarshipCatalogueRepositoryInterface as ScholarshipCatalogueRepository;

use App\Http\Requests\Scholarship\StoreScholarshipCatalogueRequest;
use App\Http\Requests\Scholarship\UpdateScholarshipCatalogueRequest;

class ScholarshipCatalogueController extends Controller
{
    protected $scholarshipCatalogueService;
    
    protected $scholarshipCatalogueRepository;

    public function __construct(
        ScholarshipCatalogueService $scholarshipCatalogueService,
        ScholarshipCatalogueRepository $scholarshipCatalogueRepository,
    ){
        $this->scholarshipCatalogueService = $scholarshipCatalogueService;
        $this->scholarshipCatalogueRepository = $scholarshipCatalogueRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'scholarship.catalogue.index');
        $scholarshipCatalogues = $this->scholarshipCatalogueService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.scholarshipCatalogue');
        $template = 'backend.scholarship.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholarshipCatalogues',
        ));
    }

    public function create(){
        $this->authorize('modules', 'scholarship.catalogue.create');
        $config = $this->config();
        $config['seo'] = __('messages.scholarshipCatalogue');
        $config['method'] = 'create';
        $template = 'backend.scholarship.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreScholarshipCatalogueRequest $request){
        if($this->scholarshipCatalogueService->create($request)){
            return redirect()->route('scholarship.catalogue.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('scholarship.catalogue.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'scholarship.catalogue.update');
        $scholarshipCatalogue = $this->scholarshipCatalogueRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.scholarshipCatalogue');
        $config['method'] = 'edit';
        $template = 'backend.scholarship.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholarshipCatalogue',
        ));
    }

    public function update($id, UpdateScholarshipCatalogueRequest $request){
        if($this->scholarshipCatalogueService->update($id, $request)){
            return redirect()->route('scholarship.catalogue.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('scholarship.catalogue.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'scholarship.catalogue.destroy');
        $config['seo'] = __('messages.scholarshipCatalogue');
        $scholarshipCatalogue = $this->scholarshipCatalogueRepository->findById($id);
        $template = 'backend.scholarship.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'scholarshipCatalogue',
            'config',
        ));
    }

    public function destroy($id){
        if($this->scholarshipCatalogueService->destroy($id)){
            return redirect()->route('scholarship.catalogue.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('scholarship.catalogue.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ],
            'model' => 'ScholarshipCatalogue'
        ];
    }

}
