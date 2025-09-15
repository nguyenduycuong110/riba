<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\SchoolCatalogueServiceInterface  as SchoolCatalogueService;
use App\Repositories\Interfaces\SchoolCatalogueRepositoryInterface as SchoolCatalogueRepository;

use App\Http\Requests\School\StoreSchoolCatalogueRequest;
use App\Http\Requests\School\UpdateSchoolCatalogueRequest;

class SchoolCatalogueController extends Controller
{
    protected $schoolCatalogueService;
    
    protected $schoolCatalogueRepository;

    public function __construct(
        schoolCatalogueService $schoolCatalogueService,
        SchoolCatalogueRepository $schoolCatalogueRepository,
    ){
        $this->schoolCatalogueService = $schoolCatalogueService;
        $this->schoolCatalogueRepository = $schoolCatalogueRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'school.catalogue.index');
        $schoolCatalogues = $this->schoolCatalogueService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.schoolCatalogue');
        $template = 'backend.school.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogues',
        ));
    }

    public function create(){
        $this->authorize('modules', 'school.catalogue.create');
        $config = $this->config();
        $config['seo'] = __('messages.schoolCatalogue');
        $config['method'] = 'create';
        $template = 'backend.school.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreSchoolCatalogueRequest $request){
        if($this->schoolCatalogueService->create($request)){
            return redirect()->route('school.catalogue.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('school.catalogue.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'school.catalogue.update');
        $schoolCatalogue = $this->schoolCatalogueRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.schoolCatalogue');
        $config['method'] = 'edit';
        $template = 'backend.school.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schoolCatalogue',
        ));
    }

    public function update($id, UpdateSchoolCatalogueRequest $request){
        if($this->schoolCatalogueService->update($id, $request)){
            return redirect()->route('school.catalogue.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('school.catalogue.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'school.catalogue.destroy');
        $config['seo'] = __('messages.schoolCatalogue');
        $schoolCatalogue = $this->schoolCatalogueRepository->findById($id);
        $template = 'backend.school.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'schoolCatalogue',
            'config',
        ));
    }

    public function destroy($id){
        if($this->schoolCatalogueService->destroy($id)){
            return redirect()->route('school.catalogue.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('school.catalogue.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'SchoolCatalogue'
        ];
    }

}
