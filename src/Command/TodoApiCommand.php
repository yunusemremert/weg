<?php

namespace App\Command;

use App\Dto\Log\TodoLog;
use App\Service\Provider\ProviderOneService;
use App\Service\Provider\ProviderTwoService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Response;

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
            $providerName = $provider->getTitleServiceName();

            try {
                $response = $provider->getTodosFromApi();

                // Log DB
                $logDto = $this->logDto($providerName, $response['message'], Response::HTTP_OK == $response['status'] ? 1 : 0);

                $provider->writeTodoLogDatabase($logDto);

                if (Response::HTTP_OK != $response['status']) {
                    $message = $response['message'] . ' : ' . $providerName;

                    $this->logger->critical($message);

                    throw new \RuntimeException($message);
                }

                $todos        = $response['message'];
                $processTodos = $provider->processTodoData($todos);

                if (empty($processTodos)) {
                    $message = 'Failed to pull data from api service : ' . $providerName;

                    $this->logger->alert($message);

                    throw new \RuntimeException($message);
                }

                $provider->writeTodoToDatabase($processTodos);

                $message = count($todos) . ' Jobs pulled from api service : ' . $providerName;

                $this->logger->info($message);

                $io->note($message);

                sleep(1);
            } catch (\Throwable $throwable) {
                // Log DB
                $logDto = $this->logDto($providerName, ['message' => $throwable->getTraceAsString()]);

                $provider->writeTodoLogDatabase($logDto);

                $this->logger->info($throwable->getTraceAsString());

                throw new \RuntimeException("Api services are not running!");
            }
        }

        sleep(2);

        $io->success('Thank you for waiting, jobs are saved in database');

        return Command::SUCCESS;
    }

    private function logDto(string $serviceName, array $responseMessage, int $responseType = 0): TodoLog
    {
        // Log DTO
        $logDto = new TodoLog();

        $logDto->setProviderName($serviceName);
        $logDto->setRequestName("getTodosFromApi");
        $logDto->setRequestBody(json_encode([]));
        $logDto->setResponseBody(json_encode($responseMessage));
        $logDto->setResponseType($responseType);
        $logDto->setCreatedAt(new \DateTime());

        return $logDto;
    }
}
