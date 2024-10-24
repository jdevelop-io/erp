<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Factory;

use JDevelop\Erp\Company\Domain\Exception\NotSupportedCountryCodeException;
use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Company\Domain\ValueObject\Siren;

final class RegistrationNumberFactory
{
    public function create(
        string $registrationNumber,
        CountryCode $countryCode
    ): RegistrationNumber {
        return match ($countryCode->unwrap()) {
            'FR' => Siren::of($registrationNumber),
            default => throw new NotSupportedCountryCodeException(
                sprintf('The country code "%s" is not supported', $countryCode->unwrap())
            )
        };
    }
}
