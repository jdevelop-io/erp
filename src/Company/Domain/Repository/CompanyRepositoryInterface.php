<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Repository;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;

interface CompanyRepositoryInterface
{
    public function save(Company $company): void;

    public function isUnique(RegistrationNumber $registrationNumber): bool;
}
