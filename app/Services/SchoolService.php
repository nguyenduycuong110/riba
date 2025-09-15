<?php

namespace App\Services;
use App\Services\Interfaces\SchoolServiceInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface as SchoolRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class SchoolService extends BaseService implements SchoolServiceInterface 
{
    protected $accountRepository;

    public function __construct(
        SchoolRepository $schoolRepository
    ){
        $this->schoolRepository = $schoolRepository;
    }

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $schools = $this->schoolRepository->schoolPagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'school/index'], 
        );
        return $schools;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send','re_password']);
            $payload['album'] = $this->formatAlbum($request);
            $school = $this->schoolRepository->create($payload);
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
            $payload['album'] = $this->formatAlbum($request);
            $school = $this->schoolRepository->update($id, $payload);
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
            $school = $this->schoolRepository->delete($id);
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
            'rate',
            'code',
            'name',
            'email',
            'image',
            'phone',
            'address',
            'map',
            'link_website',
            'logo',
            'album',
            'video',
            'description',
            'panorama',
            'information',
            'introduction',
            'publish'
        ];
    }
}
