<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use JDevelop\Erp\Shared\Domain\Exception\DomainException;

final class CompanyAlreadyExistsWithRegistrationNumberException extends DomainException
{
    public const string ERROR_KEY = 'company.registration_number.already_exists';

    public function __construct(string $registrationNumber)
    {
        parent::__construct(sprintf('Company with registration number %s already exists', $registrationNumber));
    }

    public function getErrorKey(): string
    {
        return self::ERROR_KEY;
    }
}
