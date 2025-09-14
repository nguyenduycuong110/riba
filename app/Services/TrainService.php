<?php

namespace App\Services;
use App\Services\Interfaces\TrainServiceInterface;
use App\Repositories\Interfaces\TrainRepositoryInterface as TrainRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class TrainService extends BaseService implements TrainServiceInterface 
{
    protected $trainRepository;

    public function __construct(
        TrainRepository $trainRepository
    ){
        $this->trainRepository = $trainRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $trains = $this->trainRepository->trainPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'train/index'], 
        );
        return $trains;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $train = $this->trainRepository->create($payload);
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
            $train = $this->trainRepository->update($id, $payload);
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
            $train = $this->trainRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
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
