<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Service;

use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;

interface CountryValidatorServiceInterface
{
    public function exists(CountryCode $countryCode): bool;
}
