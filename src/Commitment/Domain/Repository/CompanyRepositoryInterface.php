<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Repository;

use JDevelop\Erp\Commitment\Domain\Entity\Company;

interface CompanyRepositoryInterface
{

    public function findById(string $id): ?Company;
}
