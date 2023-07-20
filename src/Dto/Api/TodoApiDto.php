<?php

namespace App\Dto\Api;

class TodoApiDto
{
    private string $todoTitle;
    private int $todoDuration;
    private int $todoLevel = 0;

    /**
     * @return string
     */
    public function getTodoTitle(): string
    {
        return $this->todoTitle;
    }

    /**
     * @param string $todoTitle
     */
    public function setTodoTitle(string $todoTitle): void
    {
        $this->todoTitle = $todoTitle;
    }

    /**
     * @return int
     */
    public function getTodoDuration(): int
    {
        return $this->todoDuration;
    }

    /**
     * @param int $todoDuration
     */
    public function setTodoDuration(int $todoDuration): void
    {
        $this->todoDuration = $todoDuration;
    }

    /**
     * @return int
     */
    public function getTodoLevel(): int
    {
        return $this->todoLevel;
    }

    /**
     * @param int $todoLevel
     */
    public function setTodoLevel(int $todoLevel): void
    {
        $this->todoLevel = $todoLevel;
    }
}