<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Entity;

use JDevelop\Erp\Contract\Domain\ValueObject\ContractDate;

final class Contract
{
    public function __construct(
        private readonly Company $company,
        private readonly Customer $customer,
        private readonly ContractDate $beginDate,
        private readonly ContractDate $endDate,
        private ?string $id = null
    ) {
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getBeginDate(): ContractDate
    {
        return $this->beginDate;
    }

    public function getEndDate(): ContractDate
    {
        return $this->endDate;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
