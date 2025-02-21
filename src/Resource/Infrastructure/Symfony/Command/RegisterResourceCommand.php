<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Infrastructure\Symfony\Command;

use JDevelop\Erp\Resource\Application\RegisterResource\RegisterResourceDto;
use JDevelop\Erp\Resource\Application\RegisterResource\RegisterResourceService;
use JDevelop\Erp\Resource\Domain\Repository\ResourceRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'resource:register',
    description: 'Register a new resource'
)]
final class RegisterResourceCommand extends Command
{
    private const string OPTION_COMPANY_ID = 'company-id';
    private const string OPTION_FIRST_NAME = 'first-name';
    private const string OPTION_LAST_NAME = 'last-name';

    public function __construct(
        private readonly ResourceRepositoryInterface $resourceRepository,
        private readonly RegisterResourceService $registerResourceService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPTION_COMPANY_ID, null, InputOption::VALUE_REQUIRED, 'Company ID');
        $this->addOption(self::OPTION_FIRST_NAME, null, InputOption::VALUE_REQUIRED, 'First name');
        $this->addOption(self::OPTION_LAST_NAME, null, InputOption::VALUE_REQUIRED, 'Last name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyId = $input->getOption(self::OPTION_COMPANY_ID);
        $firstName = $input->getOption(self::OPTION_FIRST_NAME);
        $lastName = mb_strtoupper($input->getOption(self::OPTION_LAST_NAME));

        $resourceRegisteredDto = $this->registerResourceService->execute(
            new RegisterResourceDto($companyId, $firstName, $lastName)
        );
        $resourceRegistered = $this->resourceRepository->findById($resourceRegisteredDto->getId());

        $io->table(
            ['ID', 'Company ID', 'First name', 'Last name'],
            [
                [
                    $resourceRegistered->getId(),
                    $resourceRegistered->getCompany()->getId(),
                    $resourceRegistered->getFirstName(),
                    $resourceRegistered->getLastName()
                ]
            ]
        );

        $io->success('Resource registered successfully!');

        return Command::SUCCESS;
    }
}
