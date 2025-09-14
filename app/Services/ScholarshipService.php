<?php

namespace App\Services;
use App\Services\Interfaces\ScholarshipServiceInterface;
use App\Repositories\Interfaces\ScholarshipRepositoryInterface as ScholarshipRepository;
use Illuminate\Support\Facades\DB;

class ScholarshipService extends BaseService implements ScholarshipServiceInterface 
{
    protected $scholarshipRepository;

    public function __construct(
        ScholarshipRepository $scholarshipRepository
    ){
        $this->scholarshipRepository = $scholarshipRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $scholarships = $this->scholarshipRepository->scholarshipPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'scholarship/index'], 
        );
        return $scholarships;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $payload['scholarship_policy'] = json_encode($request->input('scholarship_policy'));
            $scholarship = $this->scholarshipRepository->create($payload);
            if($scholarship->id > 0){
                $this->createPivot($scholarship, $request);
            }
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
            $payload['scholarship_policy'] = json_encode($request->input('scholarship_policy'));
            $scholarship = $this->scholarshipRepository->update($id, $payload);
            if($scholarship->id > 0){
                $this->createPivot($scholarship, $request);
            }
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
            $scholarship = $this->scholarshipRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    private function createPivot($scholarship, $request){
        $pivotData = [];
        $schoolIds = $request->input('school_id', []);
        if(empty($schoolIds)){
            return false;
        }
        foreach($schoolIds as $schoolId){
            $pivotData[] = [
                'scholarship_id' => $scholarship->id,
                'school_id' => $schoolId
            ];
        }
        $scholarship->scholarship_schools()->detach();
        $scholarship->scholarship_schools()->attach($pivotData);
        return true;
    }
 
    private function paginateSelect(){
        return [
            'id',
            'name',
            'image',
            'scholarship_catalogue_id',
            'policy_id',
            'train_id',
            'scholarship_policy',
            'introduce',
            'content',
            'publish',
        ];
    }
}
