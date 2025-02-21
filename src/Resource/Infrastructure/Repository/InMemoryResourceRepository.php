<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Infrastructure\Repository;

use JDevelop\Erp\Resource\Domain\Entity\Resource;
use JDevelop\Erp\Resource\Domain\Repository\ResourceRepositoryInterface;

final class InMemoryResourceRepository implements ResourceRepositoryInterface
{
    /**
     * @var array<string, Resource>
     */
    private iterable $resourceById = [];

    private int $nextId = 1;

    public function save(Resource $resource): void
    {
        if ($resource->getId() === null) {
            $resource->setId((string)$this->nextId++);
        }

        $this->resourceById[$resource->getId()] = $resource;
    }

    public function findById(string $id): ?Resource
    {
        return $this->resourceById[$id] ?? null;
    }
}
