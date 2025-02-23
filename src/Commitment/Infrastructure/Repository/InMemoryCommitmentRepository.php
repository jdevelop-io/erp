<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Infrastructure\Repository;

use JDevelop\Erp\Commitment\Domain\Entity\Commitment;
use JDevelop\Erp\Commitment\Domain\Repository\CommitmentRepositoryInterface;

final class InMemoryCommitmentRepository implements CommitmentRepositoryInterface
{
    /**
     * @var array<string, Commitment>
     */
    private iterable $commitmentById = [];

    private int $nextId = 1;

    public function findById(string $id): ?Commitment
    {
        return $this->commitmentById[$id] ?? null;
    }

    public function save(Commitment $commitment): void
    {
        if ($commitment->getId() === null) {
            $commitment->setId((string)$this->nextId++);
        }

        $this->commitmentById[$commitment->getId()] = $commitment;
    }
}
