<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Symfony\Command;

use JDevelop\Erp\Contract\Application\CreateContract\CreateContractDto;
use JDevelop\Erp\Contract\Application\CreateContract\CreateContractService;
use JDevelop\Erp\Contract\Domain\Repository\ContractRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'contract:create',
    description: 'Create a new contract'
)]
final class CreateContractCommand extends Command
{
    private const string OPTION_COMPANY_ID = 'company-id';
    private const string OPTION_CUSTOMER_ID = 'customer-id';
    private const string OPTION_BEGIN_DATE = 'begin-date';
    private const string OPTION_END_DATE = 'end-date';
    private const string OPTION_NAME = 'name';

    public function __construct(
        private readonly ContractRepositoryInterface $contractRepository,
        private readonly CreateContractService $createContractService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPTION_COMPANY_ID, null, InputOption::VALUE_REQUIRED, 'Company id');
        $this->addOption(self::OPTION_CUSTOMER_ID, null, InputOption::VALUE_REQUIRED, 'Customer id');
        $this->addOption(self::OPTION_BEGIN_DATE, null, InputOption::VALUE_REQUIRED, 'Begin date');
        $this->addOption(self::OPTION_END_DATE, null, InputOption::VALUE_REQUIRED, 'End date');
        $this->addOption(self::OPTION_NAME, null, InputOption::VALUE_REQUIRED, 'Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyId = $input->getOption(self::OPTION_COMPANY_ID);
        $customerId = $input->getOption(self::OPTION_CUSTOMER_ID);
        $beginDate = $input->getOption(self::OPTION_BEGIN_DATE);
        $endDate = $input->getOption(self::OPTION_END_DATE);
        $name = $input->getOption(self::OPTION_NAME);

        $contractCreatedDto = $this->createContractService->execute(
            new CreateContractDto(
                $companyId,
                $customerId,
                $beginDate,
                $endDate,
                $name
            )
        );
        $contractCreated = $this->contractRepository->findById($contractCreatedDto->getId());

        $io->table(
            ['ID', 'Company ID', 'Customer ID', 'Begin date', 'End date', 'Name'],
            [
                [
                    $contractCreated->getId(),
                    $contractCreated->getCompany()->getId(),
                    $contractCreated->getCustomer()->getId(),
                    $contractCreated->getBeginDate()->unwrap()->format('Y-m-d'),
                    $contractCreated->getEndDate()->unwrap()->format('Y-m-d'),
                    $contractCreated->getName()
                ]
            ]
        );

        $io->success('Contract created successfully!');

        return Command::SUCCESS;
    }
}
