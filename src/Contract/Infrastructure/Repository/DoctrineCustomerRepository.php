<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Contract\Domain\Entity\Customer;
use JDevelop\Erp\Contract\Domain\Repository\CustomerRepositoryInterface;

final readonly class DoctrineCustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findById(string $id): ?Customer
    {
        $result = $this->connection->createQueryBuilder()
            ->select('id')
            ->from('customer_customer')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $data = $result->fetchAssociative();

        if ($data === false) {
            return null;
        }

        return new Customer((string)$data['id']);
    }
}
