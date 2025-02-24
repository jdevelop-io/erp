<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Infrastructure\Repository;

use JDevelop\Erp\Customer\Domain\Entity\Company;
use JDevelop\Erp\Customer\Domain\Repository\CompanyRepositoryInterface;

final class InMemoryCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var array<string, Company>
     */
    private iterable $companyById = [];

    public function findById(string $id): ?Company
    {
        return $this->companyById[$id] ?? null;
    }

    public function save(Company $company): void
    {
        $this->companyById[$company->getId()] = $company;
    }
}
