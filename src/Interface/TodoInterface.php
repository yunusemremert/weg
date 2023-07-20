<?php

namespace App\Interface;

interface TodoInterface
{
    public function getTodosFromApi(): array;
    public function processTodoData(array $todos): object;
    public function writeTodoToDatabase(object $data): void;
}