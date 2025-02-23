<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Repository;

use JDevelop\Erp\Contract\Domain\Entity\Contract;
use JDevelop\Erp\Contract\Domain\Repository\ContractRepositoryInterface;

final class InMemoryContractRepository implements ContractRepositoryInterface
{
    /**
     * @var array<string, Contract>
     */
    private iterable $contractById = [];

    private int $nextId = 1;

    public function findById(string $id): ?Contract
    {
        return $this->contractById[$id] ?? null;
    }

    public function save(Contract $contract): void
    {
        if ($contract->getId() === null) {
            $contract->setId((string)$this->nextId++);
        }

        $this->contractById[$contract->getId()] = $contract;
    }
}
