<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Application\CreateContract;

use JDevelop\Erp\Contract\Domain\Entity\Contract;
use JDevelop\Erp\Contract\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Contract\Domain\Exception\CustomerNotFoundException;
use JDevelop\Erp\Contract\Domain\Exception\InvalidDatesSequenceException;
use JDevelop\Erp\Contract\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Contract\Domain\Repository\ContractRepositoryInterface;
use JDevelop\Erp\Contract\Domain\Repository\CustomerRepositoryInterface;
use JDevelop\Erp\Contract\Domain\ValueObject\ContractDate;

final readonly class CreateContractService
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private CustomerRepositoryInterface $customerRepository,
        private ContractRepositoryInterface $contractRepository,
    ) {
    }

    public function execute(CreateContractDto $createContractDto): ContractCreatedDto
    {
        $company = $this->companyRepository->findById($createContractDto->getCompanyId());
        if ($company === null) {
            throw new CompanyNotFoundException($createContractDto->getCompanyId());
        }

        $customer = $this->customerRepository->findById($createContractDto->getCustomerId());
        if ($customer === null) {
            throw new CustomerNotFoundException($createContractDto->getCustomerId());
        }

        $beginDate = new ContractDate($createContractDto->getBeginDate());
        $endDate = new ContractDate($createContractDto->getEndDate());

        if ($beginDate->isAfter($endDate)) {
            throw new InvalidDatesSequenceException($beginDate, $endDate);
        }

        $contract = new Contract($company, $customer, $beginDate, $endDate);
        $this->contractRepository->save($contract);

        return new ContractCreatedDto($contract->getId());
    }
}
