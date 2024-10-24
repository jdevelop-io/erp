<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use JDevelop\Erp\Shared\Domain\Exception\DomainException;

final class InvalidCountryCodeException extends DomainException
{
    public const string ERROR_KEY = 'company.country.not_exists';

    public function __construct(string $value)
    {
        parent::__construct(sprintf('The country code "%s" is invalid', $value));
    }

    public function getErrorKey(): string
    {
        return self::ERROR_KEY;
    }
}
