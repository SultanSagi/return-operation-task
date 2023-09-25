<?php

namespace App\Services;

use App\Contracts\Repositories\SellerQueryRepository;
use App\Contracts\Repositories\ContractorQueryRepository;
use App\Contracts\Repositories\EmployeeQueryRepository;
use App\Contracts\Services\EmailService;
use App\DTO\ReturnOperationDTO;
use App\Enum\ReturnOperationType;

class ReturnOperationService
{
    public function __construct(
        private readonly SellerQueryRepository $sellerQueryRepository,
        private readonly ContractorQueryRepository $contractorQueryRepository,
        private readonly EmployeeQueryRepository $employeeQueryRepository,
        private readonly EmailService $emailService,
    )
    {
    }

    public function result(ReturnOperationDTO $returnOperationDTO): array
    {
        $result = [
            'notificationEmployeeByEmail' => false,
            'notificationClientByEmail'   => false,
            'notificationClientBySms'     => [
                'isSent'  => false,
                'message' => '',
            ],
        ];

        if (empty($returnOperationDTO->resellerId)) {
            $result['notificationClientBySms']['message'] = 'Empty resellerId';
            return $result;
        }

        $reseller = $this->sellerQueryRepository->findById($returnOperationDTO->resellerId);

        $client = $this->contractorQueryRepository->findBy($returnOperationDTO->clientId, Contractor::TYPE_CUSTOMER, $reseller->id);

        $templateData = $this->prepareTemplateData($returnOperationDTO, $client->getClientFullName());

        $this->emailService->sendMessage($returnOperationDTO->resellerId, $templateData);
    }

    private function prepareTemplateData(ReturnOperationDTO $returnOperationDTO, string $cFullName): array
    {
        $cr = $this->employeeQueryRepository->findById($returnOperationDTO->creatorId);

        $et = $this->employeeQueryRepository->findById($returnOperationDTO->expertId);

        $differences = '';
        if ($returnOperationDTO->notificationType === ReturnOperationType::NEW->value) {
            $differences = __('NewPositionAdded', null, $returnOperationDTO->resellerId);
        } elseif ($returnOperationDTO->notificationType === ReturnOperationType::CHANGE->value && !empty($data['differences'])) {
            $differences = __('PositionStatusHasChanged', [
                'FROM' => Status::getName((int)$data['differences']['from']),
                'TO'   => Status::getName((int)$data['differences']['to']),
            ], $returnOperationDTO->resellerId);
        }

        $templateData = [
            'COMPLAINT_ID'       => $returnOperationDTO->complaintId,
            'COMPLAINT_NUMBER'   => $returnOperationDTO->complaintNumber,
            'CREATOR_ID'         => $returnOperationDTO->creatorId,
            'CREATOR_NAME'       => $cr->getFullName(),
            'EXPERT_ID'          => $returnOperationDTO->expertId,
            'EXPERT_NAME'        => $et->getFullName(),
            'CLIENT_ID'          => $returnOperationDTO->clientId,
            'CLIENT_NAME'        => $cFullName,
            'CONSUMPTION_ID'     => $returnOperationDTO->consumptionId,
            'CONSUMPTION_NUMBER' => $returnOperationDTO->consumptionNumber,
            'AGREEMENT_NUMBER'   => $returnOperationDTO->agreementNumber,
            'DATE'               => $returnOperationDTO->date,
            'DIFFERENCES'        => $differences,
        ];

        // Если хоть одна переменная для шаблона не задана, то не отправляем уведомления
        foreach ($templateData as $key => $tempData) {
            if (empty($tempData)) {
                throw new \Exception("Template Data ({$key}) is empty!", 500);
            }
        }

        return $templateData;
    }
}