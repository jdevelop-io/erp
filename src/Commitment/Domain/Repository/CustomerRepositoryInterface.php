<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Repository;

use JDevelop\Erp\Commitment\Domain\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function findById(string $id): ?Customer;
}
