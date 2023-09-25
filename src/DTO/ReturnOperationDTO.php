<?php

namespace App\DTO;

use App\Requests\ReturnOperationRequest;

class ReturnOperationDTO
{
    public int $resellerId;
    public int $clientId;
    public int $creatorId;
    public int $expertId;
    public int $complaintId;
    public string $complaintNumber;
    public int $consumptionId;
    public string $consumptionNumber;
    public string $agreementNumber;
    public string $date;
    public int $notificationType;
    public array $differences;

    public static function fromRequest(ReturnOperationRequest $request): self
    {
        $self = new self();
        $self->resellerId = (int)$request->input('data.resellerId');
        $self->clientId = (int)$request->input('data.clientId');
        $self->creatorId = (int)$request->input('data.creatorId');
        $self->expertId = (int)$request->input('data.expertId');
        $self->notificationType = (int)$request->input('data.notificationType');
        $self->complaintId = (int)$request->input('data.complaintId');
        $self->complaintNumber = (string)$request->input('data.complaintNumber');
        $self->consumptionId = (int)$request->input('data.consumptionId');
        $self->consumptionNumber = (string)$request->input('data.consumptionNumber');
        $self->agreementNumber = (string)$request->input('data.agreementNumber');
        $self->date = (string)$request->input('data.date');
        $self->differences = (array)$request->input('data.differences');

        return $self;
    }
}