<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Contract\Domain\Entity\Company;
use JDevelop\Erp\Contract\Domain\Entity\Contract;
use JDevelop\Erp\Contract\Domain\Entity\Customer;
use JDevelop\Erp\Contract\Domain\Repository\ContractRepositoryInterface;
use JDevelop\Erp\Contract\Domain\ValueObject\ContractDate;
use RuntimeException;

final readonly class DoctrineContractRepository implements ContractRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function findById(string $id): ?Contract
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('contract_contract')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery();

        $data = $result->fetchAssociative();

        if ($data === false) {
            return null;
        }

        return new Contract(
            new Company($data['company_id']),
            new Customer((string)$data['customer_id']),
            new ContractDate($data['begin_date']),
            new ContractDate($data['end_date']),
            $data['name'],
            (string)$data['id']
        );
    }

    public function save(Contract $contract): void
    {
        $affectedRows = $this->connection->createQueryBuilder()
            ->insert('contract_contract')
            ->values([
                'company_id' => ':company_id',
                'customer_id' => ':customer_id',
                'begin_date' => ':begin_date',
                'end_date' => ':end_date',
                'name' => ':name',
            ])
            ->setParameters([
                'company_id' => $contract->getCompany()->getId(),
                'customer_id' => $contract->getCustomer()->getId(),
                'begin_date' => $contract->getBeginDate()->unwrap()->format('Y-m-d'),
                'end_date' => $contract->getEndDate()->unwrap()->format('Y-m-d'),
                'name' => $contract->getName(),
            ])
            ->executeStatement();

        if ($affectedRows !== 1) {
            throw new RuntimeException('Contract could not be saved');
        }

        $contract->setId((string)$this->connection->lastInsertId());
    }
}
