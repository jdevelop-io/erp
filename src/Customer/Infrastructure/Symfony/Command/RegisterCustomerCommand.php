<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Infrastructure\Symfony\Command;

use JDevelop\Erp\Customer\Application\RegisterCustomer\RegisterCustomerDto;
use JDevelop\Erp\Customer\Application\RegisterCustomer\RegisterCustomerService;
use JDevelop\Erp\Customer\Domain\Repository\CustomerRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'customer:register',
    description: 'Register a new customer'
)]
final class RegisterCustomerCommand extends Command
{
    private const string OPTION_COMPANY_ID = 'company-id';
    private const string OPTION_REGISTRATION_NUMBER = 'registration-number';
    private const string OPTION_NAME = 'name';

    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly RegisterCustomerService $registerCustomerService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPTION_COMPANY_ID, null, InputOption::VALUE_REQUIRED, 'Company ID');
        $this->addOption(self::OPTION_REGISTRATION_NUMBER, null, InputOption::VALUE_REQUIRED, 'Registration number');
        $this->addOption(self::OPTION_NAME, null, InputOption::VALUE_REQUIRED, 'Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyId = $input->getOption(self::OPTION_COMPANY_ID);
        $registrationNumber = $input->getOption(self::OPTION_REGISTRATION_NUMBER);
        $name = $input->getOption(self::OPTION_NAME);

        $customerRegisteredDto = $this->registerCustomerService->execute(
            new RegisterCustomerDto($companyId, $registrationNumber, $name)
        );
        $customerRegistered = $this->customerRepository->findById($customerRegisteredDto->getId());

        $io->table(
            ['ID', 'Company ID', 'Registration number', 'Name'],
            [
                [
                    $customerRegistered->getId(),
                    $customerRegistered->getCompany()->getId(),
                    $customerRegistered->getRegistrationNumber()->unwrap(),
                    $customerRegistered->getName(),
                ]
            ]
        );

        $io->success('Customer registered successfully!');

        return Command::SUCCESS;
    }
}
