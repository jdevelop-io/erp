<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Resource\Domain\Entity\Company;
use JDevelop\Erp\Resource\Domain\Entity\Resource;
use JDevelop\Erp\Resource\Domain\Repository\ResourceRepositoryInterface;
use RuntimeException;

final readonly class DoctrineResourceRepository implements ResourceRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(Resource $resource): void
    {
        $affectedRows = $this->connection->createQueryBuilder()
            ->insert('resource_resource')
            ->values([
                'company_id' => ':company_id',
                'first_name' => ':first_name',
                'last_name' => ':last_name',
            ])
            ->setParameters([
                'company_id' => $resource->getCompany()->getId(),
                'first_name' => $resource->getFirstName(),
                'last_name' => $resource->getLastName(),
            ])
            ->executeStatement();

        if ($affectedRows === 0) {
            throw new RuntimeException('Resource could not be saved');
        }

        $resource->setId((string)$this->connection->lastInsertId());
    }

    public function findById(string $id): ?Resource
    {
        $result = $this->connection->createQueryBuilder()
            ->select('company_id', 'first_name', 'last_name')
            ->from('resource_resource')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $resource = $result->fetchAssociative();

        if ($resource === false) {
            return null;
        }

        return new Resource(
            new Company($resource['company_id']),
            $resource['first_name'],
            $resource['last_name'],
            $id
        );
    }
}
