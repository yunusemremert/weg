<?php

namespace App\Service;

class TodoApiSettingService
{
    private array $apiSettings;

    public function __construct(array $apiSettings)
    {
        $this->apiSettings = $apiSettings;
    }

    public function getApiSetting(string $apiName): array
    {
        return $this->apiSettings[$apiName] ?? [];
    }
}