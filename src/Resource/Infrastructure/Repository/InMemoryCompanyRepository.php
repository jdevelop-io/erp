<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Infrastructure\Repository;

use JDevelop\Erp\Resource\Domain\Entity\Company;
use JDevelop\Erp\Resource\Domain\Repository\CompanyRepositoryInterface;

final class InMemoryCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var array<string, Company>
     */
    private iterable $companyById = [];

    public function findById(string $companyId): ?Company
    {
        return $this->companyById[$companyId] ?? null;
    }

    public function save(Company $company): void
    {
        $this->companyById[$company->getId()] = $company;
    }
}
