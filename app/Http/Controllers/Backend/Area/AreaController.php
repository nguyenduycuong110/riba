<?php

namespace App\Http\Controllers\Backend\Area;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\AreaServiceInterface  as AreaService;
use App\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;

use App\Http\Requests\Area\StoreAreaRequest;
use App\Http\Requests\Area\UpdateAreaRequest;

class AreaController extends Controller
{
    protected $areaService;
    
    protected $areaRepository;

    public function __construct(
        AreaService $areaService,
        AreaRepository $areaRepository,
    ){
        $this->areaService = $areaService;
        $this->areaRepository = $areaRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'area.index');
        $areas = $this->areaService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.area');
        $template = 'backend.area.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'areas',
        ));
    }

    public function create(){
        $this->authorize('modules', 'area.create');
        $config = $this->config();
        $config['seo'] = __('messages.area');
        $config['method'] = 'create';
        $template = 'backend.area.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreAreaRequest $request){
        if($this->areaService->create($request)){
            return redirect()->route('area.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('area.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'area.update');
        $area = $this->areaRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.area');
        $config['method'] = 'edit';
        $template = 'backend.area.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'area',
        ));
    }

    public function update($id, UpdateAreaRequest $request){
        if($this->areaService->update($id, $request)){
            return redirect()->route('area.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('area.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'area.destroy');
        $config['seo'] = __('messages.area');
        $area = $this->areaRepository->findById($id);
        $template = 'backend.area.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'area',
            'config',
        ));
    }

    public function destroy($id){
        if($this->areaService->destroy($id)){
            return redirect()->route('area.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('area.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'Area'
        ];
    }

}
