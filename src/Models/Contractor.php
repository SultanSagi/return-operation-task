<?php

namespace App\Models;

class Contractor
{
    public function getClientFullName(): string
    {
        $cFullName = $this->getFullName();
        if (empty($this->getFullName())) {
            $cFullName = $this->name;
        }
        return $cFullName;
    }
}