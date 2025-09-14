<?php

namespace App\Services;
use App\Services\Interfaces\ScholarshipCatalogueServiceInterface;
use App\Repositories\Interfaces\ScholarshipCatalogueRepositoryInterface as ScholarshipCatalogueRepository;
use Illuminate\Support\Facades\DB;

class ScholarshipCatalogueService extends BaseService implements ScholarshipCatalogueServiceInterface 
{
    protected $scholarshipCatalogueRepository;

    public function __construct(
        ScholarshipCatalogueRepository $scholarshipCatalogueRepository
    ){
        $this->scholarshipCatalogueRepository = $scholarshipCatalogueRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $scholarshipCatalogues = $this->scholarshipCatalogueRepository->scholarshipCataloguePagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'scholarship/catalogue/index'], 
        );
        return $scholarshipCatalogues;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $scholarshipCatalogue = $this->scholarshipCatalogueRepository->create($payload);
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
            $scholarshipCatalogue = $this->scholarshipCatalogueRepository->update($id, $payload);
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
            $scholarshipCatalogue = $this->scholarshipCatalogueRepository->delete($id);
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
