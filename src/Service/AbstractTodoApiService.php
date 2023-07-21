<?php

namespace App\Service;

use App\Dto\Log\TodoLog;
use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractTodoApiService
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

    protected function addTodoToDatabase(object $todos): void
    {
        foreach ($todos as $todo) {
            $todoEntity = new Todo();

            $todoEntity->setTitle($todo->getTitle());
            $todoEntity->setDuration($todo->getDuration());
            $todoEntity->setLevel($todo->getLevel());

            $this->entityManager->persist($todoEntity);
        }

        $this->entityManager->flush();
    }

    protected function writeTodoLogDatabase(TodoLog $todoLog): void
    {
        // TODO: Implement writeTodoLogDatabase() method.
    }
}