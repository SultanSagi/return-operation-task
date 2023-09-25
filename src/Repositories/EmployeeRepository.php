<?php

namespace App\Repositories;

use App\Contracts\Repositories\EmployeeQueryRepository;
use App\Models\Employee;

class EmployeeRepository implements EmployeeQueryRepository
{
    public function findById(int $id): Employee
    {
        $employee = Employee::getById($id);
        if ($employee === null) {
            throw new \Exception('Creator not found!', 400);
        }
        return $employee;
    }
}