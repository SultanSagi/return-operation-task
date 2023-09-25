<?php

namespace App\Contracts\Repositories;


use App\Models\Seller;

interface SellerQueryRepository
{
    public function findById(int $id): Seller;
}