<?php

namespace App\Contracts\Repositories;


use App\Models\Contractor;

interface ContractorQueryRepository
{
    public function findById(int $id): ?Contractor;
    public function findBy(int $id, string $type, int $sellerId): Contractor;
}