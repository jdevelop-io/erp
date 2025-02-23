<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Domain\Exception;

use Exception;

final class CustomerAlreadyRegisteredException extends Exception
{
    public function __construct(string $customerId)
    {
        parent::__construct(sprintf('Customer with id <%s> already exists', $customerId));
    }
}
