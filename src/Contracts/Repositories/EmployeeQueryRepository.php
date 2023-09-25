<?php

namespace App\Contracts\Repositories;


use App\Models\Employee;

interface EmployeeQueryRepository
{
    public function findById(int $id): Employee;
}