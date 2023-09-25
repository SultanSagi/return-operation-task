<?php

namespace App\Contracts\Services;

interface EmailService
{
    public function sendMessage(int $resellerId, array $templateData): bool;
}