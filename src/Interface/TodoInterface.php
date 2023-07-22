<?php

namespace App\Interface;

interface TodoInterface
{
    public function getTodosFromApi(): array;
    public function processTodoData(array $todos): array;
    public function writeTodoToDatabase(array $todos): void;
}