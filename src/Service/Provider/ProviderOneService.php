<?php

namespace App\Service\Provider;

use App\Dto\Api\TodoApiDto;
use App\Interface\TodoInterface;
use App\Service\AbstractTodoApiService;
use App\Service\TodoApiSettingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProviderOneService extends AbstractTodoApiService implements TodoInterface
{
    static string $name = "providerOne";

    public function __construct(
        EntityManagerInterface $entityManager,
        HttpClientInterface $httpClient,
        TodoApiSettingService $todoApiSettingService
    )
    {
        parent::__construct(
            $entityManager,
            $httpClient,
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
                'success' => 'false',
                'message' => $transportException->getTraceAsString()
            ];
        }

        return [
            'status' => 500,
            'success' => 'false',
            'message' => "Api services are not running!"
        ];
    }

    public function processTodoData(array $todos): array
    {
        $processTodosAll = [];

        foreach ($todos as $todo) {
            $processTodos = new TodoApiDto();

            $processTodos->setTitle($todo['id']);
            $processTodos->setDuration($todo['sure']);
            $processTodos->setLevel($todo['zorluk']);

            $processTodosAll[] = $processTodos;
        }

        return $processTodosAll;
    }

    public function writeTodoToDatabase(array $todos): void
    {
        $this->addTodoToDatabase($todos);
    }
}