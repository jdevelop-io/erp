<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Infrastructure\Repository;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;

final class InMemoryCompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var iterable<string, Company>
     */
    private iterable $companyByRegistrationNumber = [];

    public function __construct(iterable $companies = [])
    {
        foreach ($companies as $company) {
            $this->save($company);
        }
    }

    public function save(Company $company): void
    {
        $this->companyByRegistrationNumber[$company->getRegistrationNumber()->unwrap()] = $company;
    }

    public static function with(iterable $companies): self
    {
        return new self($companies);
    }

    public function exists(RegistrationNumber $registrationNumber): bool
    {
        return isset($this->companyByRegistrationNumber[$registrationNumber->unwrap()]);
    }

    public function findByRegistrationNumber(RegistrationNumber $registrationNumber): ?Company
    {
        return $this->companyByRegistrationNumber[$registrationNumber->unwrap()] ?? null;
    }
}
