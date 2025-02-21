<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Infrastructure\Repository;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;

final class InMemoryCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var array<string, Company>
     */
    private iterable $companyByRegistrationNumber = [];

    public function save(Company $company): void
    {
        $this->companyByRegistrationNumber[$company->getRegistrationNumber()->unwrap()] = $company;
    }

    public function isUnique(RegistrationNumber $registrationNumber): bool
    {
        return !isset($this->companyByRegistrationNumber[$registrationNumber->unwrap()]);
    }

    public function findByRegistrationNumber(string $registrationNumber): ?Company
    {
        return $this->companyByRegistrationNumber[$registrationNumber] ?? null;
    }
}
