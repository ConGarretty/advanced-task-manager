<?php

namespace App\Service;

use App\Process\TaskManagerProcess;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Traits\Process\TaskManagerProcessTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

/**
 * class TaskManagerService
 * @package App\Service
 */
class TaskManagerService
{
    use TaskManagerProcessTrait;

    /**
     * @param EntityManagerInterface $entityManager
     * @param TaskManagerProcess $taskManagerProcess
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected TaskManagerProcess $taskManagerProcess
    ) {
    }

    /**
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return array
     */
    public function getTasks(
        int $page,
        string $sort = TaskRepository::DEFAULT_SORT_FIELD,
        string $direction = TaskRepository::DEFAULT_SORT_DIRECTION
    ): array {
        return $this->getTaskManagerProcess()->fetchTasks($page, $sort, $direction);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function createTask(Task $task): Task
    {
        return $this->getTaskManagerProcess()->saveTask($task);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function toggleTask(Task $task): Task
    {
        return $this->getTaskManagerProcess()->saveTask($task->setIsDone(!$task->getIsDone()));
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function deleteTask(Task $task): Task
    {
        return $this->getTaskManagerProcess()->saveTask($task->setDeletedAt(new DateTime()));
    }
}
