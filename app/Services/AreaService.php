<?php

namespace App\Services;
use App\Services\Interfaces\AreaServiceInterface;
use App\Repositories\Interfaces\AreaRepositoryInterface as AreaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class AreaService extends BaseService implements AreaServiceInterface 
{
    protected $areaRepository;

    public function __construct(
        AreaRepository $areaRepository
    ){
        $this->areaRepository = $areaRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $areas = $this->areaRepository->areaPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'area/index'], 
        );
        return $areas;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $data = $this->convertData($payload);
            $area = count($data) == 1 ? $this->areaRepository->create($data[0]) : $this->areaRepository->updateOrInsert($data);
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
            $area = $this->areaRepository->update($id, $payload);
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
            $area = $this->areaRepository->delete($id);
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
