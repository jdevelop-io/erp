<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Resource\Domain\Entity\Company;
use JDevelop\Erp\Resource\Domain\Repository\CompanyRepositoryInterface;

final readonly class DoctrineCompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findById(string $companyId): ?Company
    {
        $result = $this->connection->createQueryBuilder()
            ->select('registration_number')
            ->from('company_company')
            ->where('registration_number = :id')
            ->setParameter('id', $companyId)
            ->executeQuery();

        $company = $result->fetchAssociative();

        if ($company === false) {
            return null;
        }

        return new Company($company['registration_number']);
    }
}
