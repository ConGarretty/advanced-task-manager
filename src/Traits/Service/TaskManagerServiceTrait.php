<?php

namespace App\Traits\Service;

use App\Service\TaskManagerService;

/**
 * Class TaskManagerServiceTrait
 * @package App\Traits\Service
 */
trait TaskManagerServiceTrait
{
    /** @var TaskManagerService $taskManagerService */
    protected TaskManagerService $taskManagerService;

    /**
     * @return TaskManagerService
     */
    public function getTaskManagerService(): TaskManagerService
    {
        return $this->taskManagerService;
    }

    /**
     * @param TaskManagerService $taskManagerService
     * @return self
     */
    public function setTaskManagerService(TaskManagerService $taskManagerService): self
    {
        $this->taskManagerService = $taskManagerService;

        return $this;
    }
}
