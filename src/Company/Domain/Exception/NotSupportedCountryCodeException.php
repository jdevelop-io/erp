<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Exception;

use JDevelop\Erp\Shared\Domain\Exception\DomainException;

final class NotSupportedCountryCodeException extends DomainException
{
    public const string ERROR_KEY = 'company.country.not_supported';

    public function getErrorKey(): string
    {
        return self::ERROR_KEY;
    }
}
