<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Application\CreateContract;

final readonly class CreateContractDto
{
    public function __construct(
        private string $companyId,
        private string $customerId,
        private string $beginDate,
        private string $endDate,
        private string $name,
    ) {
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getBeginDate(): string
    {
        return $this->beginDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
