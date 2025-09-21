<?php  
namespace App\Services\V2\Impl\Hotel;
use App\Services\V2\BaseService;
use App\Repositories\Hotel\HotelCatalogueRepo;
use Illuminate\Support\Facades\Auth;

class HotelCatalogueService extends BaseService {

    protected $repository;

    protected $fillable;

    protected $with = ['users'];

    public function __construct(
        HotelCatalogueRepo $repository,
    )
    {
        $this->repository = $repository;
    }

    public function prepareModelData(): static {
        $request = $this->context['request'] ?? null;
        if(!is_null($request)){
            $this->fillable = $this->repository->getFillable();
            $this->modelData = $request->only($this->fillable);
            $this->modelData['user_id'] = Auth::id();
        }
        return $this;
    }


}