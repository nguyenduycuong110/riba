<?php

namespace App\Services\Interfaces;

/**
 * Interface ProjectServiceInterface
 * @package App\Services\Interfaces
 */
interface ProjectServiceInterface 
{
    public function paginate($request);
    public function create($request);
}
