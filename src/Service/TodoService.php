<?php

namespace App\Service;

use App\Entity\Developer;
use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;

final class TodoService
{
    private \Doctrine\ORM\EntityRepository $developers;
    private \Doctrine\ORM\EntityRepository $todos;

    public function __construct(protected EntityManagerInterface $entityManager)
    {
        $this->developers = $this->entityManager->getRepository(Developer::class);
        $this->todos = $this->entityManager->getRepository(Todo::class);
    }

    private function assignTodos(array $todos, int $week = 1): array
    {
        $assignTodos = [];
        $assignedTodosId = [];
        $response = [];

        foreach ($this->developers->findAll() as $developer) {
            $weeklyHours = 0;

            foreach ($todos as $key => $todo) {
                $todoDuration = $todo->getDuration();

                if ($weeklyHours <= 45 && ($weeklyHours + $todoDuration) <= 45) {
                    if ($todo->getLevel() > $todo->getDuration() && $developer->getLevel() * $todo->getDuration() < $todo->getLevel()) {
                        continue;
                    }

                    $assignTodos[] = [
                        'devId' => $developer->getId(),
                        'devName' => $developer->getName(),
                        'week' => $week,
                        'title' => $todo->getTitle(),
                        'level' => $todo->getLevel(),
                        'duration' => $todoDuration
                    ];

                    $assignedTodosId[] = $todo->getId();
                    $weeklyHours += $todoDuration;

                    unset($todos[$key]);
                }
            }
        }

        $unAssignedTodos = $this->removeAssignedTodos($todos, $assignedTodosId);

        if (count($unAssignedTodos) > 0) {
            $response = $this->assignTodos($unAssignedTodos, $week + 1);
        }

        return array_merge($response, $assignTodos);
    }

    public function getAssignedTodos(): array
    {
        $assignedTodos = $this->assignTodos($this->todos->findAll());

        $assignedGroupTodos = $this->arrayGroupByKey($assignedTodos);

        return $this->assignWeekTodos($assignedGroupTodos);
    }

    private function removeAssignedTodos(array $todos, array $assignedTodos): array
    {
        foreach ($todos as $key => $todo) {
            if (in_array($todo->getId(), $assignedTodos)) {
                unset($todo[$key]);
            }
        }

        return $todos;
    }

    private function arrayGroupByKey(array $data): array
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists('devId', $val)) {
                $result[$val['devId']][] = $val;
            } else {
                $result[''][] = $val;
            }
        }

        return $result;
    }

    private function assignWeekTodos(array $todos): array
    {
        $assignedWeekTodos = [];

        foreach ($todos as $key => $todoWeek) {
            $assignedWeekTodos[$todoWeek[0]['devId']]['name'] = $todoWeek[0]['devName'];

            krsort($todoWeek);

            $weekDuration = [];
            foreach ($todoWeek as $todo) {
                $weekDuration[$todoWeek[0]['devId']][$todo['week']][] = $todo['duration'];
            }

            $totalDuration = 0;

            foreach ($todoWeek as $todo) {
                $assignedWeekTodos[$todoWeek[0]['devId']]['weekTodos'][$todo['week']]['todos'][] = [
                    'title' => $todo['title'],
                    'level' => $todo['level'],
                    'duration' => $todo['duration']
                ];

                $assignedWeekTodos[$todoWeek[0]['devId']]['weekTodos'][$todo['week']]['weekDuration'] = array_sum($weekDuration[$todoWeek[0]['devId']][$todo['week']]);

                $totalDuration += $todo['duration'];
            }

            $assignedWeekTodos[$todoWeek[0]['devId']]['totalDuration'] = $totalDuration;
        }

        return $assignedWeekTodos;
    }
}