<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Repository;

use JDevelop\Erp\Commitment\Domain\Entity\Commitment;

interface CommitmentRepositoryInterface
{
    public function findById(string $id): ?Commitment;

    public function save(Commitment $commitment): void;
}
