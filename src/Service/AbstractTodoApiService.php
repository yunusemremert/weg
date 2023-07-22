<?php

namespace App\Service;

use App\Dto\Log\TodoLog;
use App\Entity\RequestLog;
use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractTodoApiService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected HttpClientInterface $httpClient,
        private readonly TodoApiSettingService $todoApiSettingService
    )
    {
    }

    protected function getApiSettings(string $providerName): array
    {
        return $this->todoApiSettingService->getApiSetting($providerName);
    }

    protected function addTodoToDatabase(array $todos): void
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
        $requestLog = new RequestLog();

        $requestLog->setProviderName($todoLog->getProviderName());
        $requestLog->setRequestName($todoLog->getRequestName());
        $requestLog->setRequestBody($todoLog->getRequestBody());
        $requestLog->setResponseBody($todoLog->getResponseBody());
        $requestLog->setResponseType($todoLog->getResponseType());
        $requestLog->setCreatedAt($todoLog->getCreatedAt());

        $this->entityManager->persist($requestLog);
        $this->entityManager->flush();
    }
}