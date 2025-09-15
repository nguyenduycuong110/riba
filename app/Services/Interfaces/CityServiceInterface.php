<?php

namespace App\Services\Interfaces;

/**
 * Interface CityServiceInterface
 * @package App\Services\Interfaces
 */
interface CityServiceInterface 
{
    public function paginate($request);
    public function create($request);
}
