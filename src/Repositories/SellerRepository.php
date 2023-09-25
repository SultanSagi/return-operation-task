<?php

namespace App\Repositories;

use App\Contracts\Repositories\SellerQueryRepository;
use App\Models\Seller;

class SellerRepository implements SellerQueryRepository
{

    public function findById(int $id): Seller
    {
        $seller = Seller::getById($id);
        if ($seller === null) {
            throw new \Exception('Seller not found!', 400);
        }
        $seller;
    }
}