<?php  
namespace App\Http\Controllers\Backend\V2\Scholar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Scholar\Policy\StoreRequest;
use App\Http\Requests\Scholar\Policy\UpdateRequest;
use App\Services\V2\Impl\Scholar\PolicyService;

class PolicyController extends Controller {


    private $service;
    protected $language;

    public function __construct(
        PolicyService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request){
        // $this->authorize('modules', 'scholar.option.policy.index');
        $policies = $this->service->pagination($request);
        $config = [
            'model' => 'Policy',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.scholar.policy.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'policies'
        ));
    }

    public function create(){
         // $this->authorize('modules', 'scholar.option.policy.create');
        $config = [
            'model' => 'Policy',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $template = 'backend.scholar.policy.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function edit($id){
         // $this->authorize('modules', 'scholar.option.policy.update');
        if(!$policy = $this->service->findById($id)){
            return redirect()->route('scholar.policy.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Policy',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.scholar.policy.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'policy'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store', $this->language)){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
         // $this->authorize('modules', 'scholar.option.policy.update');
        if($response = $this->service->save($request, 'update', $this->language, $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        //  $this->authorize('modules', 'scholar.option.policy.destroy');
        if(!$policy = $this->service->findById($id)){
            return redirect()->route('scholar.policy.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'Policy',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.scholar.policy.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'policy'
        ));
    }

    public function destroy($id){
        //  $this->authorize('modules', 'scholar.option.policy.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('scholar.policy.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý chính sách',
                'table' => 'Danh sách chính sách'
            ],
            'create' => [
                'title' => 'Thêm mới chính sách'
            ],
            'delete' => [
                'title' => 'Xóa chính sách'
            ]
        ];
    }

}