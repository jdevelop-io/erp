<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Repository;

use JDevelop\Erp\Contract\Domain\Entity\Company;

interface CompanyRepositoryInterface
{

    public function findById(string $id): ?Company;
}
