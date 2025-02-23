<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Repository;

use JDevelop\Erp\Contract\Domain\Entity\Contract;

interface ContractRepositoryInterface
{
    public function findById(string $id): ?Contract;

    public function save(Contract $contract): void;
}
