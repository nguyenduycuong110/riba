<?php

namespace App\Http\Controllers\Backend\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ScholarshipServiceInterface  as ScholarshipService;
use App\Repositories\Interfaces\ScholarshipRepositoryInterface as ScholarshipRepository;
use App\Repositories\Interfaces\ScholarshipCatalogueRepositoryInterface as ScholarshipCatalogueRepository;
use App\Repositories\Interfaces\PolicyRepositoryInterface as PolicyRepository;
use App\Repositories\Interfaces\TrainRepositoryInterface as TrainRepository;
use App\Repositories\Interfaces\SchoolRepositoryInterface as SchoolRepository;

use App\Http\Requests\Scholarship\StoreScholarshipRequest;
use App\Http\Requests\Scholarship\UpdateScholarshipRequest;
use Illuminate\Support\Facades\DB;

class ScholarshipController extends Controller
{
    protected $scholarshipService;
    protected $scholarshipRepository;
    protected $scholarshipCatalogueRepository;
    protected $policyRepository;
    protected $trainRepository;
    protected $schoolRepository;

    public function __construct(
        ScholarshipService $scholarshipService,
        ScholarshipRepository $scholarshipRepository,
        ScholarshipCatalogueRepository $scholarshipCatalogueRepository,
        PolicyRepository $policyRepository,
        TrainRepository $trainRepository,
        SchoolRepository $schoolRepository,
    ){
        $this->scholarshipService = $scholarshipService;
        $this->scholarshipRepository = $scholarshipRepository;
        $this->scholarshipCatalogueRepository = $scholarshipCatalogueRepository;
        $this->policyRepository = $policyRepository;
        $this->trainRepository = $trainRepository;
        $this->schoolRepository = $schoolRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'scholarship.index');
        $scholarships = $this->scholarshipService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.scholarship');
        $template = 'backend.scholarship.scholarship.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholarships',
        ));
    }

    public function create(){
        $this->authorize('modules', 'scholarship.create');
        $scholarshipCatalogues = $this->scholarshipCatalogueRepository->all([]);
        $policies =  $this->policyRepository->all([]);
        $trains =  $this->trainRepository->all([]);
        $schools =  $this->schoolRepository->all([]);
        $config = $this->config();
        $config['seo'] = __('messages.scholarship');
        $config['method'] = 'create';
        $template = 'backend.scholarship.scholarship.store';
        return view('backend.dashboard.layout', compact(
            'scholarshipCatalogues',
            'policies',
            'trains',
            'schools',
            'template',
            'config',
        ));
    }

    public function store(StoreScholarshipRequest $request){
        if($this->scholarshipService->create($request)){
            return redirect()->route('scholarship.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('scholarship.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'scholarship.update');
        $scholarship = $this->scholarshipRepository->findById($id);
        $schoolIds = DB::table('scholarship_school')->where('scholarship_id', $scholarship->id)->get()->pluck('school_id')->toArray();
        $scholarshipCatalogues = $this->scholarshipCatalogueRepository->all([]);
        $policies =  $this->policyRepository->all([]);
        $trains =  $this->trainRepository->all([]);
        $schools =  $this->schoolRepository->all([]);
        $config = $this->config();
        $config['seo'] = __('messages.scholarship');
        $config['method'] = 'edit';
        $template = 'backend.scholarship.scholarship.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'scholarship',
            'scholarshipCatalogues',
            'policies',
            'trains',
            'schools',
            'schoolIds'
        ));
    }

    public function update($id, UpdateScholarshipRequest $request){
        if($this->scholarshipService->update($id, $request)){
            return redirect()->route('scholarship.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('scholarship.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'scholarship.destroy');
        $config['seo'] = __('messages.scholarship');
        $scholarship = $this->scholarshipRepository->findById($id);
        $template = 'backend.scholarship.scholarship.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'scholarship',
            'config',
        ));
    }

    public function destroy($id){
        if($this->scholarshipService->destroy($id)){
            return redirect()->route('scholarship.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('scholarship.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/policy.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ],
            'model' => 'Scholarship'
        ];
    }

}
