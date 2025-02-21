<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use Exception;

final class CompanyAlreadyRegisteredException extends Exception
{
    public function __construct(string $registrationNumber)
    {
        parent::__construct(
            sprintf('Company with registration number <%s> is already registered', $registrationNumber)
        );
    }
}
