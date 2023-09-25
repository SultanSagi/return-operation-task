<?php

namespace App\Repositories;

use App\Contracts\Repositories\ContractorQueryRepository;
use App\Models\Contractor;
use Exception;

class ContractorRepository implements ContractorQueryRepository
{

    public function findById(int $id): ?Contractor
    {
        return Contractor::getById($id);
    }

    // эти параметре можно передать через DTO
    public function findBy(int $id, string $type, int $sellerId): Contractor
    {
        $client = $this->findById($id);
        if ($client === null || $client->type !== $type || $client->Seller->id !== $sellerId) {
            throw new Exception('сlient not found!', 400);
        }
        return $client;
    }
}