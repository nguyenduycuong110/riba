<?php

namespace App\Services\Interfaces;

/**
 * Interface SchoolServiceInterface
 * @package App\Services\Interfaces
 */
interface SchoolCatalogueServiceInterface 
{
    public function paginate($request);
    public function create($request);
}
