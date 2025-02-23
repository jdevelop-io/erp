<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Application\RegisterCustomer;

use JDevelop\Erp\Customer\Domain\Entity\Customer;
use JDevelop\Erp\Customer\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Customer\Domain\Exception\CustomerAlreadyRegisteredException;
use JDevelop\Erp\Customer\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Customer\Domain\Repository\CustomerRepositoryInterface;
use JDevelop\Erp\Customer\Domain\ValueObject\Siren;

final readonly class RegisterCustomerService
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private CustomerRepositoryInterface $customerRepository
    ) {
    }

    public function execute(RegisterCustomerDto $registerCustomerDto): CustomerRegisteredDto
    {
        $company = $this->companyRepository->findById($registerCustomerDto->getCompanyId());
        if ($company === null) {
            throw new CompanyNotFoundException($registerCustomerDto->getCompanyId());
        }

        $registrationNumber = new Siren($registerCustomerDto->getRegistrationNumber());
        if ($this->customerRepository->existsByRegistrationNumber($company, $registrationNumber)) {
            throw new CustomerAlreadyRegisteredException($registerCustomerDto->getRegistrationNumber());
        }

        $name = $registerCustomerDto->getName();
        $customer = new Customer($company, $registrationNumber, $name);
        $this->customerRepository->save($customer);

        return new CustomerRegisteredDto($customer->getId());
    }
}
