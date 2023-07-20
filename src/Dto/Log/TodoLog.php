<?php

namespace App\Dto\Log;

class TodoLog
{
    private string $errorTitle;
    private string $errorMessage;
    private int $errorType = 0;

    /**
     * @return string
     */
    public function getErrorTitle(): string
    {
        return $this->errorTitle;
    }

    /**
     * @param string $errorTitle
     */
    public function setErrorTitle(string $errorTitle): void
    {
        $this->errorTitle = $errorTitle;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorType(): int
    {
        return $this->errorType;
    }

    /**
     * @param int $errorType
     */
    public function setErrorType(int $errorType): void
    {
        $this->errorType = $errorType;
    }
}