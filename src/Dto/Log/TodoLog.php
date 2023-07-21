<?php

namespace App\Dto\Log;

class TodoLog
{
    private string $providerName;
    private string $requestName;
    private string $requestBody;
    private string $responseBody;
    private int $responseType = 0; // 0: Error, 1: Success

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @param string $providerName
     */
    public function setProviderName(string $providerName): void
    {
        $this->providerName = $providerName;
    }

    /**
     * @return string
     */
    public function getRequestName(): string
    {
        return $this->requestName;
    }

    /**
     * @param string $requestName
     */
    public function setRequestName(string $requestName): void
    {
        $this->requestName = $requestName;
    }

    /**
     * @return string
     */
    public function getRequestBody(): string
    {
        return $this->requestBody;
    }

    /**
     * @param string $requestBody
     */
    public function setRequestBody(string $requestBody): void
    {
        $this->requestBody = $requestBody;
    }

    /**
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    /**
     * @param string $responseBody
     */
    public function setResponseBody(string $responseBody): void
    {
        $this->responseBody = $responseBody;
    }

    /**
     * @return int
     */
    public function getResponseType(): int
    {
        return $this->responseType;
    }

    /**
     * @param int $responseType
     */
    public function setResponseType(int $responseType): void
    {
        $this->responseType = $responseType;
    }
}