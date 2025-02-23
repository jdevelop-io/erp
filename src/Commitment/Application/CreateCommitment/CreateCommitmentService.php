<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Application\CreateCommitment;

use JDevelop\Erp\Commitment\Domain\Entity\Commitment;
use JDevelop\Erp\Commitment\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Commitment\Domain\Exception\CustomerNotFoundException;
use JDevelop\Erp\Commitment\Domain\Exception\InvalidDatesSequenceException;
use JDevelop\Erp\Commitment\Domain\Repository\CommitmentRepositoryInterface;
use JDevelop\Erp\Commitment\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Commitment\Domain\Repository\CustomerRepositoryInterface;
use JDevelop\Erp\Commitment\Domain\ValueObject\CommitmentDate;

final readonly class CreateCommitmentService
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private CustomerRepositoryInterface $customerRepository,
        private CommitmentRepositoryInterface $commitmentRepository,
    ) {
    }

    public function execute(CreateCommitmentDto $createCommitmentDto): CommitmentCreatedDto
    {
        $company = $this->companyRepository->findById($createCommitmentDto->getCompanyId());
        if ($company === null) {
            throw new CompanyNotFoundException($createCommitmentDto->getCompanyId());
        }

        $customer = $this->customerRepository->findById($createCommitmentDto->getCustomerId());
        if ($customer === null) {
            throw new CustomerNotFoundException($createCommitmentDto->getCustomerId());
        }

        $beginDate = new CommitmentDate($createCommitmentDto->getBeginDate());
        $endDate = new CommitmentDate($createCommitmentDto->getEndDate());

        if ($beginDate->isAfter($endDate)) {
            throw new InvalidDatesSequenceException($beginDate, $endDate);
        }

        $commitment = new Commitment($company, $customer, $beginDate, $endDate);
        $this->commitmentRepository->save($commitment);

        return new CommitmentCreatedDto($commitment->getId());
    }
}
