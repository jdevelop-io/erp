<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Domain\Exception;

use Exception;

final class CompanyNotFoundException extends Exception
{
    public function __construct(string $companyId)
    {
        parent::__construct(sprintf('Company with id <%s> not found', $companyId));
    }
}
