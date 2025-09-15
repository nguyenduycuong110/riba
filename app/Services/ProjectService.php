<?php

namespace App\Services;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface as ProjectRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class ProjectService extends BaseService implements ProjectServiceInterface 
{
    protected $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository
    ){
        $this->projectRepository = $projectRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $projects = $this->projectRepository->projectPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'project/index'], 
        );
        return $projects;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $data = $this->convertData($payload);
            $project = count($data) == 1 ? $this->projectRepository->create($data[0]) : $this->projectRepository->updateOrInsert($data);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $project = $this->projectRepository->update($id, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $project = $this->projectRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    private function convertData($payload){
        $temp = [];
        foreach($payload['name'] as $k => $v){
            $temp[$k]['name'] = $v;
        }
        return $temp;
    }

    private function paginateSelect(){
        return [
            'id',
            'name',
            'publish'
        ];
    }
}
