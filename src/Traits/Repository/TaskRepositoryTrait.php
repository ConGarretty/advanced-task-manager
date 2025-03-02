<?php

namespace App\Traits\Repository;

use App\Repository\TaskRepository;

/**
 * Class TaskRepositoryTrait
 * @package App\Traits\Repository
 */
trait TaskRepositoryTrait
{
    /** @var TaskRepository $taskRepository */
    protected TaskRepository $taskRepository;

    /**
     * @return TaskRepository
     */
    public function getTaskRepository(): TaskRepository
    {
        return $this->taskRepository;
    }

    /**
     * @param TaskRepository $taskRepository
     * @return self
     */
    public function setTaskRepository(TaskRepository $taskRepository): self
    {
        $this->taskRepository = $taskRepository;

        return $this;
    }
}
