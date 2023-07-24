<?php

namespace App\Controller;

use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    public function __construct(protected TodoService $todoService)
    {
    }

    #[Route('/', name: 'app_todo')]
    public function index(): Response
    {
        $todos = $this->todoService->getAssignedTodos();

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }
}
