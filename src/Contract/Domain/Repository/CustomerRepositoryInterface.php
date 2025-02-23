<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Repository;

use JDevelop\Erp\Contract\Domain\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function findById(string $id): ?Customer;
}
