<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Infrastructure\Service;

use JDevelop\Erp\Company\Domain\Service\CountryValidatorServiceInterface;
use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;

final class InMemoryCountryValidatorService implements CountryValidatorServiceInterface
{
    private function __construct(private iterable $countries = [])
    {
        foreach ($countries as $country) {
            $this->add($country);
        }
    }

    private function add(string $countryCode): void
    {
        $this->countries[] = $countryCode;
    }

    public static function with(iterable $countries): self
    {
        return new self($countries);
    }

    public function exists(CountryCode $countryCode): bool
    {
        return in_array($countryCode->unwrap(), $this->countries, true);
    }
}
