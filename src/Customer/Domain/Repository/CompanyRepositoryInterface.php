<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Domain\Repository;

use JDevelop\Erp\Customer\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findById(string $id): ?Company;
}
