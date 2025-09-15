<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProjectServiceInterface  as ProjectService;
use App\Repositories\Interfaces\ProjectRepositoryInterface as ProjectRepository;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;
    
    protected $projectRepository;

    public function __construct(
        ProjectService $projectService,
        ProjectRepository $projectRepository,
    ){
        $this->projectService = $projectService;
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'project.index');
        $projects = $this->projectService->paginate($request);
        $config = $this->config();
        $config['seo'] = __('messages.project');
        $template = 'backend.project.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'projects',
        ));
    }

    public function create(){
        $this->authorize('modules', 'project.create');
        $config = $this->config();
        $config['seo'] = __('messages.project');
        $config['method'] = 'create';
        $template = 'backend.project.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreProjectRequest $request){
        if($this->projectService->create($request)){
            return redirect()->route('project.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('project.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'project.update');
        $project = $this->projectRepository->findById($id);
        $config = $this->config();
        $config['seo'] = __('messages.project');
        $config['method'] = 'edit';
        $template = 'backend.project.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'project',
        ));
    }

    public function update($id, UpdateProjectRequest $request){
        if($this->projectService->update($id, $request)){
            return redirect()->route('project.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('project.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'project.destroy');
        $config['seo'] = __('messages.project');
        $project = $this->projectRepository->findById($id);
        $template = 'backend.project.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'project',
            'config',
        ));
    }

    public function destroy($id){
        if($this->projectService->destroy($id)){
            return redirect()->route('project.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('project.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
            'model' => 'Project'
        ];
    }

}
