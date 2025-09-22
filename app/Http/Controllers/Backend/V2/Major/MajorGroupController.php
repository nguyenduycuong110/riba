<?php  
namespace App\Http\Controllers\Backend\V2\Major;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Major\MajorGroup\StoreRequest;
use App\Http\Requests\Major\MajorGroup\UpdateRequest;
use App\Services\V2\Impl\Major\MajorGroupService;
use App\Models\Language;

class MajorGroupController extends Controller {


    private $service;
    protected $language;

    public function __construct(
        MajorGroupService $service
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
        $this->authorize('modules', 'major_group.index');
        $majorGroups = $this->service->pagination($request);
        $config = [
            'model' => 'MajorGroup',
            'seo' => $this->seo(),
            'extendJs' => true
        ];
        $template = 'backend.major.major_group.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorGroups'
        ));
    }

    public function create(){
        $this->authorize('modules', 'major_group.create');
        $config = [
            'model' => 'MajorGroup',
            'seo' => $this->seo(),
            'method' => 'create',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.major.major_group.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown'
        ));
    }

    public function edit($id){
        $this->authorize('modules', 'major_group.update');
        if(!$majorGroup = $this->service->findById($id)){
            return redirect()->route('major.major_group.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'MajorGroup',
            'seo' => $this->seo(),
            'method' => 'update',
            'extendJs' => true
        ];
        $dropdown = $this->service->dropdown();
        $template = 'backend.major.major_group.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorGroup',
            'dropdown'
        ));     
    }
    
    public function store(StoreRequest $request){
        if($response = $this->service->save($request, 'store')){
            return redirect()->back()->with('success', 'Khởi tạo bản ghi thành công');
        }
        return redirect()->back()->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function update($id, UpdateRequest $request){
        $this->authorize('modules', 'major_group.update');
        if($response = $this->service->save($request, 'update', $id)){
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->back()->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'major_group.destroy');
        if(!$majorGroup = $this->service->findById($id)){
            return redirect()->route('major_group.index')->with('error','Bản ghi không tồn tại'); 
        }
        $config = [
            'model' => 'MajorGroup',
            'seo' => $this->seo(),
            'method' => 'update'
        ];
        $template = 'backend.major.major_group.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'majorGroup'
        ));
    }

    public function destroy($id){
        $this->authorize('modules', 'major_group.destroy');
        if($response = $this->service->destroy($id)){
            return redirect()->route('major_group.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->back()->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }


    private function seo(){
        return [
            'index' => [
                'title' => 'Quản lý nhóm ngành',
                'table' => 'Danh sách nhóm ngành'
            ],
            'create' => [
                'title' => 'Thêm mới nhóm ngành'
            ],
            'update' => [
                'title' => 'Cập nhật nhóm ngành'
            ],
            'delete' => [
                'title' => 'Xóa nhóm ngành'
            ]
        ];
    }

}