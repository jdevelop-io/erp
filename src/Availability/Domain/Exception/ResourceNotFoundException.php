<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Exception;

use Exception;

final class ResourceNotFoundException extends Exception
{
    public function __construct(string $resourceId)
    {
        parent::__construct(sprintf('Resource with id <%s> not found', $resourceId));
    }
}
