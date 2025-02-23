<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Exception;

use Exception;

final class CustomerNotFoundException extends Exception
{
    public function __construct(string $customerId)
    {
        parent::__construct(sprintf('Customer with id <%s> not found', $customerId));
    }
}
