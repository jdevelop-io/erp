<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Repository;


use JDevelop\Erp\Availability\Domain\Entity\Resource;
use JDevelop\Erp\Availability\Domain\Repository\ResourceRepositoryInterface;

final class InMemoryResourceRepository implements ResourceRepositoryInterface
{
    private iterable $resourceById = [];

    public function findById(string $id): ?Resource
    {
        return $this->resourceById[$id] ?? null;
    }

    public function save(Resource $resource): void
    {
        $this->resourceById[$resource->getId()] = $resource;
    }
}
