<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Exception\CompanyAlreadyExistsWithRegistrationNumberException;
use JDevelop\Erp\Company\Domain\Exception\InvalidCountryCodeException;
use JDevelop\Erp\Company\Domain\Factory\RegistrationNumberFactory;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Company\Domain\Service\CountryValidatorServiceInterface;
use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Shared\Domain\Exception\DomainException;

final readonly class RegisterCompanyUseCase
{
    public function __construct(
        private CountryValidatorServiceInterface $countryValidatorService,
        private CompanyRepositoryInterface $companyRepository,
        private RegistrationNumberFactory $registrationNumberFactory
    ) {
    }

    public function execute(RegisterCompanyRequest $request): RegisterCompanyResponse
    {
        try {
            $countryCode = CountryCode::of($request->getCountryCode());

            $this->ensureCountryExists($countryCode);

            $registrationNumber = $this->registrationNumberFactory->create(
                $request->getRegistrationNumber(),
                $countryCode
            );

            $this->ensureRegistrationNumberIsUnique($registrationNumber);

            $company = Company::register($registrationNumber, $countryCode);

            $this->companyRepository->save($company);

            return RegisterCompanyResponse::success($company->getRegistrationNumber()->unwrap());
        } catch (DomainException $exception) {
            return RegisterCompanyResponse::fail($exception->getErrorKey());
        }
    }

    private function ensureCountryExists(CountryCode $countryCode): void
    {
        if (!$this->countryValidatorService->exists($countryCode)) {
            throw new InvalidCountryCodeException($countryCode->unwrap());
        }
    }

    private function ensureRegistrationNumberIsUnique(RegistrationNumber $registrationNumber): void
    {
        if ($this->companyRepository->exists($registrationNumber)) {
            throw new CompanyAlreadyExistsWithRegistrationNumberException($registrationNumber->unwrap());
        }
    }
}
