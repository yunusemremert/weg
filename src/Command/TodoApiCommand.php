<?php

namespace App\Command;

use App\Service\Provider\ProviderOneService;
use App\Service\Provider\ProviderTwoService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:get-todo-api',
    description: 'Pulls incoming to-do business information from providers',
)]
class TodoApiCommand extends Command
{
    private LoggerInterface $logger;
    private array $providers;

    public function __construct(
        LoggerInterface $logger,
        ProviderOneService $providerOneService,
        ProviderTwoService $providerTwoService
    )
    {
        parent::__construct();

        $this->logger = $logger;

        $this->providers = [$providerOneService, $providerTwoService];
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->caution('Please make database connection settings before things are pulled from api');

        sleep(2);

        $io->ask('Is your database connection active?', 'yes', function (string $status): string { // no
            if ($status != 'yes') {
                throw new \RuntimeException('Please activate the database connection');
            }

            return $status;
        });

        $io->section('Please wait while the jobs are being retrieved from the API');

        sleep(2);

        foreach ($this->providers as $provider) {
            try {
                $response = $provider->getTodosFromApi();

                if ($response['status'] == 200) {
                    $todos        = $response['message'];
                    $processTodos = $provider->processTodoData($todos);

                    if (empty($processTodos)) {
                        $message = 'Failed to pull data from api service : ' . $provider->getTitleServiceName();

                        $this->logger->alert($message);

                        throw new \RuntimeException($message);
                    }

                    $provider->writeTodoToDatabase($processTodos);

                    $message = count($todos) . ' Jobs pulled from api service : ' . $provider->getTitleServiceName();

                    $this->logger->info($message);

                    $io->note($message);
                } else {
                    $message = $response['message'] . ' : ' . $provider->getTitleServiceName();

                    $this->logger->critical($message);

                    throw new \RuntimeException($message);
                }

                sleep(1);
            } catch (\Throwable $throwable) {
                $this->logger->info($throwable->getTraceAsString());

                throw new \RuntimeException("Api services are not running!");
            }
        }

        sleep(2);

        $io->success('Thank you for waiting, jobs are saved in database');

        return Command::SUCCESS;
    }
}
