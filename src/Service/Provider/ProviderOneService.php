<?php

namespace App\Service\Provider;

use App\Dto\Api\TodoApiDto;
use App\Interface\TodoInterface;
use App\Service\TodoApiService;
use App\Service\TodoApiSettingService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProviderOneService extends TodoApiService implements TodoInterface
{
    static string $name = "providerOne";

    public function __construct(
        EntityManagerInterface $entityManager,
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        TodoApiSettingService $todoApiSettingService
    )
    {
        parent::__construct(
            $entityManager,
            $httpClient,
            $logger,
            $todoApiSettingService
        );

        $apiSettings = $this->getApiSettings($this->getTitleServiceName());

        $this->httpClient = $this->httpClient->withOptions([
            'base_uri' => $apiSettings['url']
        ]); // $this->getApiSettings('secret_key')
    }

    public function getTitleServiceName(): string
    {
        return self::$name;
    }

    public function getTodosFromApi(): array
    {
        try {
            $response = $this->httpClient->request('GET', '');

            if ($response->getStatusCode() == Response::HTTP_OK) {
                return [
                    'status' => 200,
                    'success' => 'true',
                    'message' => $response->toArray()
                ];
            }
        }  catch (TransportExceptionInterface $transportException) {
            return [
                'status' => 400,
                'success' => false,
                'message' => $transportException->getTraceAsString()
            ];
        }
    }

    public function processTodoData(array $todos): object
    {
        $processTodosAll = [];

        foreach ($todos as $todo) {
            $processTodos = new TodoApiDto();

            $processTodos->setTodoTitle($todo['id']);
            $processTodos->setTodoDuration($todo['sure']);
            $processTodos->setTodoLevel($todo['zorluk']);

            $processTodosAll[] = $processTodos;
        }

        return (object) $processTodosAll;
    }

    public function writeTodoToDatabase(object $data): void
    {
        $this->addTodoToDatabase($data);
    }
}