<?php

declare(strict_types=1);

namespace JDevelop\Erp\Test\Unit\Company\Application;

use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyRequest;
use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyResponse;
use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyUseCase;
use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Exception\CompanyAlreadyExistsWithRegistrationNumberException;
use JDevelop\Erp\Company\Domain\Exception\InvalidCountryCodeException;
use JDevelop\Erp\Company\Domain\Exception\InvalidRegistrationNumberException;
use JDevelop\Erp\Company\Domain\Exception\NotSupportedCountryCodeException;
use JDevelop\Erp\Company\Domain\Factory\RegistrationNumberFactory;
use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Company\Domain\ValueObject\Siren;
use JDevelop\Erp\Company\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Company\Infrastructure\Service\InMemoryCountryValidatorService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegisterCompanyUseCase::class)]
#[CoversClass(RegisterCompanyRequest::class)]
#[CoversClass(RegisterCompanyResponse::class)]
#[CoversClass(RegistrationNumberFactory::class)]
#[CoversClass(InMemoryCountryValidatorService::class)]
#[CoversClass(InMemoryCompanyRepository::class)]
#[CoversClass(Company::class)]
#[CoversClass(RegistrationNumber::class)]
#[CoversClass(Siren::class)]
#[CoversClass(CountryCode::class)]
#[CoversClass(InvalidCountryCodeException::class)]
#[CoversClass(NotSupportedCountryCodeException::class)]
#[CoversClass(InvalidRegistrationNumberException::class)]
#[CoversClass(CompanyAlreadyExistsWithRegistrationNumberException::class)]
final class RegisterCompanyTest extends TestCase
{
    /**
     * @return iterable<iterable<string>>
     */
    public static function invalidRegistrationNumbersDataProvider(): iterable
    {
        return [
            [''],
            ['FR1234567'],
            ['12345678'],
            ['1234567890'],
            ['123456783']
        ];
    }

    /**
     * @return iterable<iterable<string>>
     */
    public static function invalidCountryCodesDataProvider(): iterable
    {
        return [
            [''],
            ['ESP'],
            ['01']
        ];
    }

    protected function setUp(): void
    {
        $this->countryValidatorService = InMemoryCountryValidatorService::with(['US', 'FR']);
        $this->companyRepository = InMemoryCompanyRepository::with([
            Company::register(Siren::of('123456782'), CountryCode::of('FR')),
        ]);
        $this->registrationNumberFactory = new RegistrationNumberFactory();
        $this->useCase = new RegisterCompanyUseCase(
            $this->countryValidatorService,
            $this->companyRepository,
            $this->registrationNumberFactory
        );
    }

    #[DataProvider('invalidCountryCodesDataProvider')]
    public function testCountryCodeShouldBeValid(string $countryCode): void
    {
        $request = new RegisterCompanyRequest('123456782', $countryCode);

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isFailure());
        $this->assertSame(InvalidCountryCodeException::ERROR_KEY, $response->getErrorKey());
    }

    public function testCountryShouldExists(): void
    {
        $request = new RegisterCompanyRequest('123456782', 'ES');

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isFailure());
        $this->assertSame(InvalidCountryCodeException::ERROR_KEY, $response->getErrorKey());
    }

    public function testCountryShouldBeSupported(): void
    {
        $request = new RegisterCompanyRequest('123456782', 'US');

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isFailure());
        $this->assertSame(NotSupportedCountryCodeException::ERROR_KEY, $response->getErrorKey());
    }

    public function testCompanyShouldBeUniqueByRegistrationNumber(): void
    {
        $request = new RegisterCompanyRequest('123456782', 'FR');

        $this->useCase->execute($request);

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isFailure());
        $this->assertSame(CompanyAlreadyExistsWithRegistrationNumberException::ERROR_KEY, $response->getErrorKey());
    }

    #[DataProvider('invalidRegistrationNumbersDataProvider')]
    public function testRegistrationNumberShouldBeValid(string $registrationNumber): void
    {
        $request = new RegisterCompanyRequest($registrationNumber, 'FR');

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isFailure());
        $this->assertSame(InvalidRegistrationNumberException::ERROR_KEY, $response->getErrorKey());
    }

    public function testCompanyShouldBeCreated(): void
    {
        $request = new RegisterCompanyRequest('831699459', 'FR');

        $response = $this->useCase->execute($request);

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('831699459', $response->getRegistrationNumber());

        $company = $this->companyRepository->findByRegistrationNumber(Siren::of('831699459'));
        $this->assertNotNull($company);
        $this->assertSame('831699459', $company->getRegistrationNumber()->unwrap());
        $this->assertSame('FR', $company->getCountryCode()->unwrap());
    }
}
