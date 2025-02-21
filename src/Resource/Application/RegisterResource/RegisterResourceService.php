<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Application\RegisterResource;

use JDevelop\Erp\Resource\Domain\Entity\Resource;
use JDevelop\Erp\Resource\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Resource\Domain\Repository\CompanyRepositoryInterface;
use JDevelop\Erp\Resource\Domain\Repository\ResourceRepositoryInterface;

final readonly class RegisterResourceService
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private ResourceRepositoryInterface $resourceRepository
    ) {
    }

    public function execute(RegisterResourceDto $registerResourceDto): ResourceRegisteredDto
    {
        $company = $this->companyRepository->findById($registerResourceDto->getCompanyId());
        if ($company === null) {
            throw new CompanyNotFoundException($registerResourceDto->getCompanyId());
        }

        $resource = new Resource($company, $registerResourceDto->getFirstName(), $registerResourceDto->getLastName());
        $this->resourceRepository->save($resource);

        return new ResourceRegisteredDto($resource->getId());
    }
}
