<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Domain\Repository;

use JDevelop\Erp\Resource\Domain\Entity\Company;

interface CompanyRepositoryInterface
{

    public function findById(string $companyId): ?Company;
}
