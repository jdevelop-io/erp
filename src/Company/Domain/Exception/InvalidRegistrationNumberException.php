<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use JDevelop\Erp\Shared\Domain\Exception\DomainException;

final class InvalidRegistrationNumberException extends DomainException
{
    public const string ERROR_KEY = 'company.registration_number.invalid';

    public function __construct(string $value)
    {
        parent::__construct(sprintf('The registration number "%s" is invalid', $value));
    }

    public function getErrorKey(): string
    {
        return self::ERROR_KEY;
    }
}
