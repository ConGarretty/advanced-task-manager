<?php

namespace App\Process;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Traits\Repository\TaskRepositoryTrait;

/**
 * class TaskManagerProcess
 * @package App\Process
 */
class TaskManagerProcess
{
    use TaskRepositoryTrait;

    /**
     * @param TaskRepository $taskRepository
     */
    public function __construct(protected TaskRepository $taskRepository)
    {
    }

    /**
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return array
     */
    public function fetchTasks(int $page, string $sort, string $direction): array
    {
        return $this->getTaskRepository()->findActiveTasks($page, $sort, $direction);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function saveTask(Task $task): Task
    {
        $this->getTaskRepository()->save($task);

        return $task;
    }
}
