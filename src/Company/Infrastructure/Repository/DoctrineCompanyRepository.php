<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;
use RuntimeException;

final readonly class DoctrineCompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(Company $company): void
    {
        $affectedRows = $this->connection->createQueryBuilder()
            ->insert('company_company')
            ->values([
                'registration_number' => ':registration_number',
                'name' => ':name',
            ])
            ->setParameters([
                'registration_number' => $company->getRegistrationNumber()->unwrap(),
                'name' => $company->getName(),
            ])
            ->executeStatement();

        if ($affectedRows !== 1) {
            throw new RuntimeException('The company could not be saved.');
        }
    }

    public function isUnique(RegistrationNumber $registrationNumber): bool
    {
        $result = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('company_company')
            ->where('registration_number = :registration_number')
            ->setParameter('registration_number', $registrationNumber->unwrap())
            ->executeQuery();

        return (int)$result->fetchOne() === 0;
    }
}
