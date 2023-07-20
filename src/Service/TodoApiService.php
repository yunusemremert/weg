<?php

namespace App\Service;

use App\Dto\Log\TodoLog;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class TodoApiService extends TodoApiSettingService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected HttpClientInterface $httpClient,
        private LoggerInterface $logger,
        private readonly TodoApiSettingService $todoApiSettingService
    )
    {
    }

    protected function getApiSettings(string $providerName): array
    {
        return $this->todoApiSettingService->getApiSetting($providerName);
    }

    #[NoReturn] protected function addTodoToDatabase(object $data): void
    {
        dd($data);
    }

    public function writeTodoLogDatabase(TodoLog $todoLog): void
    {
        // TODO: Implement writeTodoLogDatabase() method.
    }
}