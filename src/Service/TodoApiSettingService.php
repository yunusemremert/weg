<?php

namespace App\Service;

class TodoApiSettingService
{
    private array $apiSettings;

    public function __construct(array $apiSettings)
    {
        $this->apiSettings = $apiSettings;
    }

    protected function getApiSetting(string $apiName): array
    {
        return $this->apiSettings[$apiName] ?? [];
    }
}