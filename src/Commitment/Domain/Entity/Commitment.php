<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Entity;

use JDevelop\Erp\Commitment\Domain\ValueObject\CommitmentDate;

final class Commitment
{
    public function __construct(
        private readonly Company $company,
        private readonly Customer $customer,
        private readonly CommitmentDate $beginDate,
        private readonly CommitmentDate $endDate,
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

    public function getBeginDate(): CommitmentDate
    {
        return $this->beginDate;
    }

    public function getEndDate(): CommitmentDate
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
