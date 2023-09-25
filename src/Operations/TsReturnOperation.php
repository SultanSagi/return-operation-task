<?php

namespace App\Operations;

use App\DTO\ReturnOperationDTO;
use App\Services\ReturnOperationService;

class TsReturnOperation
{
    public function __construct(
        private readonly ReturnOperationService $returnOperationService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function doOperation(ReturnOperationDTO $returnOperationDTO): array
    {
        return $this->returnOperationService->result($returnOperationDTO);
    }
}