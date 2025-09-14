<?php

namespace App\Http\Controllers\Backend\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\TrainServiceInterface  as TrainService;
use App\Repositories\Interfaces\TrainRepositoryInterface as TrainRepository;

use App\Http\Requests\Train\StoreTrainRequest;
use App\Http\Requests\Train\UpdateTrainRequest;

class TrainController extends Controller
{
    protected $trainService;
    
    protected $trainRepository;

    public function __construct(
        TrainService $trainService,
        TrainRepository $trainRepository,
    ){
        $this->trainService = $trainService;
        $this->trainRepository = $trainRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'train.index');
        $trains = $this->trainService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.train');
        $template = 'backend.train.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'trains',
        ));
    }

    public function create(){
        $this->authorize('modules', 'train.create');
        $config = $this->config();
        $config['seo'] = __('messages.train');
        $config['method'] = 'create';
        $template = 'backend.train.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreTrainRequest $request){
        if($this->trainService->create($request)){
            return redirect()->route('train.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('train.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'train.update');
        $train = $this->trainRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.train');
        $config['method'] = 'edit';
        $template = 'backend.train.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'train',
        ));
    }

    public function update($id, UpdateTrainRequest $request){
        if($this->trainService->update($id, $request)){
            return redirect()->route('train.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('train.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'train.destroy');
        $config['seo'] = __('messages.train');
        $train = $this->trainRepository->findById($id);
        $template = 'backend.train.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'train',
            'config',
        ));
    }

    public function destroy($id){
        if($this->trainService->destroy($id)){
            return redirect()->route('train.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('train.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'Train'
        ];
    }

}
