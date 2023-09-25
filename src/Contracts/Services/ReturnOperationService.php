<?php

namespace App\Contracts\Services;

use App\DTO\ReturnOperationDTO;

interface ReturnOperationService
{
    public function result(ReturnOperationDTO $returnOperationDTO): array;
}