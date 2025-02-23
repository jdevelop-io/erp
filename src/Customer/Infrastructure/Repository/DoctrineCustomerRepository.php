<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Customer\Domain\Entity\Company;
use JDevelop\Erp\Customer\Domain\Entity\Customer;
use JDevelop\Erp\Customer\Domain\Repository\CustomerRepositoryInterface;
use JDevelop\Erp\Customer\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Customer\Domain\ValueObject\Siren;
use RuntimeException;

final readonly class DoctrineCustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }


    public function save(Customer $customer): void
    {
        $affectedRows = $this->connection->createQueryBuilder()
            ->insert('customer_customer')
            ->values([
                'company_id' => ':company_id',
                'registration_number' => ':registration_number',
                'name' => ':name',
            ])
            ->setParameters([
                'company_id' => $customer->getCompany()->getId(),
                'registration_number' => $customer->getRegistrationNumber()->unwrap(),
                'name' => $customer->getName(),
            ])
            ->executeStatement();

        if ($affectedRows !== 1) {
            throw new RuntimeException('The customer has not been saved');
        }

        $customer->setId((string)$this->connection->lastInsertId());
    }

    public function existsByRegistrationNumber(Company $company, RegistrationNumber $registrationNumber): bool
    {
        $result = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('customer_customer')
            ->where('company_id = :company_id')
            ->andWhere('registration_number = :registration_number')
            ->setParameters([
                'company_id' => $company->getId(),
                'registration_number' => $registrationNumber->unwrap(),
            ])
            ->executeQuery();

        return (int)$result->fetchOne() > 0;
    }

    public function findById(string $id): ?Customer
    {
        $result = $this->connection->createQueryBuilder()
            ->select('company_id', 'registration_number', 'name')
            ->from('customer_customer')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $data = $result->fetchAssociative();

        if ($data === false) {
            return null;
        }

        return new Customer(
            new Company($data['company_id']),
            new Siren($data['registration_number']),
            $data['name'],
            $id
        );
    }
}
