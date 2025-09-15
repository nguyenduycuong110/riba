<?php

namespace App\Http\Controllers\Backend\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\CityServiceInterface  as CityService;
use App\Repositories\Interfaces\CityRepositoryInterface as CityRepository;
use App\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;

use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;

class CityController extends Controller
{
    protected $cityService;
    
    protected $cityRepository;

    protected $areaRepository;

    public function __construct(
        CityService $cityService,
        CityRepository $cityRepository,
        AreaRepository $areaRepository,
    ){
        $this->cityService = $cityService;
        $this->cityRepository = $cityRepository;
        $this->areaRepository = $areaRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'city.index');
        $cities = $this->cityService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.city');
        $template = 'backend.city.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'cities',
        ));
    }

    public function create(){
        $this->authorize('modules', 'city.create');
        $areas = $this->areaRepository->all([]);
        $config = $this->config();
        $config['seo'] = __('messages.city');
        $config['method'] = 'create';
        $template = 'backend.city.store';
        return view('backend.dashboard.layout', compact(
            'areas',
            'template',
            'config',
        ));
    }

    public function store(StoreCityRequest $request){
        if($this->cityService->create($request)){
            return redirect()->route('city.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'city.update');
        $areas = $this->areaRepository->all([]);
        $city = $this->cityRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.city');
        $config['method'] = 'edit';
        $template = 'backend.city.store';
        return view('backend.dashboard.layout', compact(
            'areas',
            'template',
            'config',
            'city',
        ));
    }

    public function update($id, UpdateCityRequest $request){
        if($this->cityService->update($id, $request)){
            return redirect()->route('city.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'city.destroy');
        $config['seo'] = __('messages.city');
        $city = $this->cityRepository->findById($id);
        $template = 'backend.city.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'city',
            'config',
        ));
    }

    public function destroy($id){
        if($this->cityService->destroy($id)){
            return redirect()->route('city.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('city.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'City'
        ];
    }

}
