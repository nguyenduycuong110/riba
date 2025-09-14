<?php

namespace App\Http\Controllers\Backend\Scholarship;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PolicyServiceInterface  as PolicyService;
use App\Repositories\Interfaces\PolicyRepositoryInterface as PolicyRepository;

use App\Http\Requests\Policy\StorePolicyRequest;
use App\Http\Requests\Policy\UpdatePolicyRequest;

class PolicyController extends Controller
{
    protected $policyService;
    
    protected $policyRepository;

    public function __construct(
        PolicyService $policyService,
        PolicyRepository $policyRepository,
    ){
        $this->policyService = $policyService;
        $this->policyRepository = $policyRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'policy.index');
        $policies = $this->policyService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.policy');
        $template = 'backend.policy.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'policies',
        ));
    }

    public function create(){
        $this->authorize('modules', 'policy.create');
        $config = $this->config();
        $config['seo'] = __('messages.policy');
        $config['method'] = 'create';
        $template = 'backend.policy.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StorePolicyRequest $request){
        if($this->policyService->create($request)){
            return redirect()->route('policy.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('policy.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'policy.update');
        $policy = $this->policyRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.policy');
        $config['method'] = 'edit';
        $template = 'backend.policy.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'policy',
        ));
    }

    public function update($id, UpdatePolicyRequest $request){
        if($this->policyService->update($id, $request)){
            return redirect()->route('policy.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('policy.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'policy.destroy');
        $config['seo'] = __('messages.policy');
        $policy = $this->policyRepository->findById($id);
        $template = 'backend.policy.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'policy',
            'config',
        ));
    }

    public function destroy($id){
        if($this->policyService->destroy($id)){
            return redirect()->route('policy.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('policy.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'Policy'
        ];
    }

}
