<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Availability\Domain\Entity\Resource;
use JDevelop\Erp\Availability\Domain\Repository\ResourceRepositoryInterface;

final readonly class DoctrineResourceRepository implements ResourceRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findById(string $id): ?Resource
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('resource_resource')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $resource = $result->fetchAssociative();

        if ($resource === false) {
            return null;
        }

        return new Resource(
            (string)$resource['id'],
        );
    }
}
