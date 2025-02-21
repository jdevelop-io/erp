<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use Exception;

final class InvalidRegistrationNumberException extends Exception
{
    public function __construct(string $registrationNumber)
    {
        parent::__construct(sprintf('The registration number <%s> is invalid', $registrationNumber));
    }
}
