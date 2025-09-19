<?php  
namespace App\Http\Controllers\Backend\V2\Scholar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Scholar\Train\StoreRequest;
use App\Http\Requests\Scholar\Train\UpdateRequest;
use App\Services\V2\Impl\Scholar\TrainService;

class TrainController extends Controller {


    private $service;
    protected $language;

    public function __construct(
        TrainService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request){
        // $this->authorize('modules', 'scholar.option.train.index');
        $trains = $this->service->pagination($request);
        $config = [
            'model' => 'ScholarTrain',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.scholar.train.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'trains'
        ));
    }

    public function create(){
         // $this->authorize('modules', 'scholar.option.train.create');
        $config = [
            'model' => 'ScholarTrain',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.scholar.train.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'scholar.option.train.update');
        if(!$train = $this->service->findById($id)){
            return redirect()->route('scholar.train.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'ScholarTrain',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $template = 'backend.scholar.train.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'train'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store')){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
         // $this->authorize('modules', 'scholar.option.train.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'scholar.option.train.destroy');
        if(!$train = $this->service->findById($id)){
            return redirect()->route('scholar.train.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'ScholarTrain',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.scholar.train.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'train'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'scholar.option.train.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('scholar.train.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý hệ đào tạo',
                'table' => 'Danh sách hệ đào tạo'
            ],
            'create' => [
                'title' => 'Thêm mới hệ đào tạo'
            ],
            'update' => [
                'title' => 'Cập nhật hệ đào tạo'
            ],
            'delete' => [
                'title' => 'Xóa hệ đào tạo'
            ]
        ];
    }

}