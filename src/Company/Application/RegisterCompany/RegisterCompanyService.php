<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\Exception\CompanyAlreadyRegisteredException;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Company\Domain\ValueObject\Siren;

final readonly class RegisterCompanyService
{
    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    public function execute(RegisterCompanyDto $registerCompanyDto): CompanyRegisteredDto
    {
        $registrationNumber = new Siren($registerCompanyDto->getRegistrationNumber());
        if (!$this->companyRepository->isUnique($registrationNumber)) {
            throw new CompanyAlreadyRegisteredException($registerCompanyDto->getRegistrationNumber());
        }

        $company = new Company($registrationNumber, $registerCompanyDto->getName());
        $this->companyRepository->save($company);

        return new CompanyRegisteredDto($company->getRegistrationNumber()->unwrap());
    }
}
