<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Contract\Domain\Entity\Company;
use JDevelop\Erp\Contract\Domain\Repository\CompanyRepositoryInterface;

final readonly class DoctrineCompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findById(string $id): ?Company
    {
        $result = $this->connection->createQueryBuilder()
            ->select('registration_number')
            ->from('company_company')
            ->where('registration_number = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $data = $result->fetchAssociative();

        if ($data === false) {
            return null;
        }

        return new Company($data['registration_number']);
    }
}
