<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Domain\Repository;

use JDevelop\Erp\Resource\Domain\Entity\Resource;

interface ResourceRepositoryInterface
{
    public function save(Resource $resource): void;
}
