<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Infrastructure\Symfony\Command;

use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyDto;
use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyService;
use JDevelop\Erp\Company\Domain\Repository\CompanyRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'company:register',
    description: 'Register a new company'
)]
final class RegisterCompanyCommand extends Command
{
    private const string OPTION_REGISTRATION_NUMBER = 'registration-number';
    private const string OPTION_NAME = 'name';

    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly RegisterCompanyService $registerCompanyService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            self::OPTION_REGISTRATION_NUMBER,
            null,
            InputOption::VALUE_REQUIRED,
            'The registration number of the company'
        );
        $this->addOption(self::OPTION_NAME, null, InputOption::VALUE_REQUIRED, 'The name of the company');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $registrationNumber = $input->getOption(self::OPTION_REGISTRATION_NUMBER);
        $name = $input->getOption(self::OPTION_NAME);

        $companyRegisteredDto = $this->registerCompanyService->execute(
            new RegisterCompanyDto($registrationNumber, $name)
        );
        $companyRegistered = $this->companyRepository->findByRegistrationNumber(
            $companyRegisteredDto->getRegistrationNumber()
        );

        $io->table(
            ['Registration Number', 'Name'],
            [[$companyRegistered->getRegistrationNumber()->unwrap(), $companyRegistered->getName()]]
        );

        $io->success('Company registered successfully!');

        return Command::SUCCESS;
    }
}
