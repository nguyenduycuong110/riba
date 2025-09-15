<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\SchoolServiceInterface  as SchoolService;
use App\Repositories\Interfaces\SchoolRepositoryInterface as SchoolRepository;
use App\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use App\Http\Requests\School\StoreSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;

class SchoolController extends Controller
{
    protected $schoolService;
    
    protected $schoolRepository;

    protected $areaRepository;

    protected $cityRepository;

    public function __construct(
        SchoolService $schoolService,
        SchoolRepository $schoolRepository,
        AreaRepository $areaRepository,
        CityRepository $cityRepository,
    ){
        $this->schoolService = $schoolService;
        $this->schoolRepository = $schoolRepository;
        $this->areaRepository = $areaRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'school.index');
        $schools = $this->schoolService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.school');
        $template = 'backend.school.school.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'schools',
        ));
    }

    public function create(){
        $this->authorize('modules', 'school.create');
        $areas = $this->areaRepository->all([]);
        $cities = $this->cityRepository->all([]);
        $config = $this->config();
        $config['seo'] = __('messages.school');
        $config['method'] = 'create';
        $template = 'backend.school.school.store';
        return view('backend.dashboard.layout', compact(
            'areas',
            'cities',
            'template',
            'config',
        ));
    }

    public function store(StoreSchoolRequest $request){
        if($this->schoolService->create($request)){
            return redirect()->route('school.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('school.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'school.update');
        $school = $this->schoolRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.school');
        $config['method'] = 'edit';
        $template = 'backend.school.school.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'school',
        ));
    }

    public function update($id, UpdateSchoolRequest $request){
        if($this->schoolService->update($id, $request)){
            return redirect()->route('school.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('school.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'school.destroy');
        $config['seo'] = __('messages.school');
        $school = $this->schoolRepository->findById($id);
        $template = 'backend.school.school.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'school',
            'config',
        ));
    }

    public function destroy($id){
        if($this->schoolService->destroy($id)){
            return redirect()->route('school.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('school.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'School'
        ];
    }

}
