<?php

namespace App\Services\Interfaces;

/**
 * Interface AttributeServiceInterface
 * @package App\Services\Interfaces
 */
interface TrainServiceInterface 
{
    public function paginate($request);
    public function create($request);
}
