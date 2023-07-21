<?php

namespace App\Service\Provider;

use App\Dto\Api\TodoApiDto;
use App\Interface\TodoInterface;
use App\Service\AbstractTodoApiService;
use App\Service\TodoApiSettingService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ProviderTwoService extends AbstractTodoApiService implements TodoInterface
{
    static string $name = "providerTwo";

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

        return [
            'status' => 500,
            'success' => false,
            'message' => "Api services are not running!"
        ];
    }

    public function processTodoData(array $todos): object
    {
        $processTodosAll = [];

        foreach ($todos as $todo) {
            $content = array_values($todo)[0];

            $processTodos = new TodoApiDto();

            $processTodos->setTitle(array_key_first($todo));
            $processTodos->setDuration($content['estimated_duration']);
            $processTodos->setLevel($content['level']);

            $processTodosAll[] = $processTodos;
        }

        return (object) $processTodosAll;
    }

    public function writeTodoToDatabase(object $todos): void
    {
        $this->addTodoToDatabase($todos);
    }
}