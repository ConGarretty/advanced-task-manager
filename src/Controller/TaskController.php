<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskForm;
use App\Repository\TaskRepository;
use App\Service\TaskManagerService;
use App\Service\TaskMetaDataService;
use App\Traits\Service\TaskManagerServiceTrait;
use App\Traits\Service\TaskMetaDataServiceTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * class TaskController
 * @package App\Controller
 */
class TaskController extends AbstractController
{
    use TaskManagerServiceTrait;
    use TaskMetaDataServiceTrait;

    public const ROUTE_PREFIX = "/tasks";
    public const ROUTE_TASK_INDEX = "task-index";
    public const ROUTE_TASK_CREATE = "task-create";
    public const ROUTE_TASK_TOGGLE = "task-toggle";
    public const ROUTE_TASK_DELETE = "task-delete";
    public const TASK_CREATED_SUCCESSFULLY = "Task created successfully!";
    public const TASK_DELETED_SUCCESSFULLY = "Task deleted successfully!";

    /**
     * @param TaskManagerService $taskManagerService
     * @param TaskMetaDataService $taskMetaDataService
     */
    public function __construct(
        protected TaskManagerService $taskManagerService,
        protected TaskMetaDataService $taskMetaDataService
    ) {
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route(self::ROUTE_PREFIX, name: self::ROUTE_TASK_INDEX, methods: ["GET"])]
    public function index(Request $request): Response
    {
        return $this->renderTaskList($request, $this->createForm(TaskForm::class, new Task()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route(self::ROUTE_PREFIX, name: self::ROUTE_TASK_CREATE, methods: [Request::METHOD_POST])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(TaskForm::class, new Task());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Task $task */
            $task = $form->getData();
            $this->getTaskManagerService()->createTask($task);
            $this->addFlash("success", self::TASK_CREATED_SUCCESSFULLY);

            return $this->redirectToRoute(self::ROUTE_TASK_INDEX);
        }

        return $this->renderTaskList($request, $form);
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    #[Route(self::ROUTE_PREFIX . "/{id}/toggle", name: self::ROUTE_TASK_TOGGLE, methods: [Request::METHOD_POST])]
    public function toggle(Task $task): JsonResponse
    {
        $updatedTask = $this->getTaskManagerService()->toggleTask($task);

        return $this->json(["isDone" => $updatedTask->getIsDone(), "taskId" => $updatedTask->getId(),]);
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    #[Route(self::ROUTE_PREFIX . "/{id}/delete", name: self::ROUTE_TASK_DELETE, methods: [Request::METHOD_POST])]
    public function delete(Task $task): JsonResponse
    {
        $this->getTaskManagerService()->deleteTask($task);

        return $this->json(["success" => true, "message" => self::TASK_DELETED_SUCCESSFULLY,]);
    }

    /**
     * @param Request $request
     * @param $form
     * @return Response
     */
    protected function renderTaskList(Request $request, $form): Response
    {
        $page = $request->query->getInt("page", 1);
        $sort = $request->query->get("sort", TaskRepository::DEFAULT_SORT_FIELD);
        $direction = $request->query->get("direction", TaskRepository::DEFAULT_SORT_DIRECTION);

        $tasks = $this->getTaskManagerService()->getTasks($page, $sort, $direction);
        $taskData = $this->getTaskMetaDataService()->prepareTasksWithMetaData($tasks, $page, $sort, $direction);

        return $this->render("task/index.html.twig", ["taskData" => $taskData, "form" => $form]);
    }
}
