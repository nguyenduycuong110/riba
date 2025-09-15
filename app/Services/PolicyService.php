<?php

namespace App\Services;
use App\Services\Interfaces\PolicyServiceInterface;
use App\Repositories\Interfaces\PolicyRepositoryInterface as PolicyRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class PolicyService extends BaseService implements PolicyServiceInterface 
{
    protected $policyRepository;

    public function __construct(
        PolicyRepository $policyRepository
    ){
        $this->policyRepository = $policyRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $policys = $this->policyRepository->policyPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'policy/index'], 
        );
        return $policys;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $data = $this->convertData($payload);
            $policy = count($data) == 1 ? $this->policyRepository->create($data[0]) : $this->policyRepository->updateOrInsert($data);
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
            $policy = $this->policyRepository->update($id, $payload);
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
            $policy = $this->policyRepository->delete($id);
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
            'note',
            'publish',
        ];
    }
}
