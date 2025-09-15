<?php

namespace App\Services;
use App\Services\Interfaces\SchoolCatalogueServiceInterface;
use App\Repositories\Interfaces\SchoolCatalogueRepositoryInterface as SchoolCatalogueRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class SchoolCatalogueService extends BaseService implements SchoolCatalogueServiceInterface 
{
    protected $schoolCatalogueRepository;

    public function __construct(
        SchoolCatalogueRepository $schoolCatalogueRepository
    ){
        $this->schoolCatalogueRepository = $schoolCatalogueRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $schoolCatalogues = $this->schoolCatalogueRepository->schoolCataloguePagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'school/catalogue/index'], 
        );
        return $schoolCatalogues;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $data = $this->convertData($payload);
            $schoolCatalogue = count($data) == 1 ? $this->schoolCatalogueRepository->create($data[0]) : $this->schoolCatalogueRepository->updateOrInsert($data);
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
            $schoolCatalogue = $this->schoolCatalogueRepository->update($id, $payload);
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
            $schoolCatalogue = $this->schoolCatalogueRepository->delete($id);
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
