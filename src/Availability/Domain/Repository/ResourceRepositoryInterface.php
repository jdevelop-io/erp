<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Repository;

use JDevelop\Erp\Availability\Domain\Entity\Resource;

interface ResourceRepositoryInterface
{
    public function findById(string $getResourceId): ?Resource;
}
