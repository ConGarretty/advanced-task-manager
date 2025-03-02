<?php

namespace App\Traits\Process;

use App\Process\TaskManagerProcess;

/**
 * Class TaskManagerProcessTrait
 * @package App\Traits\Process
 */
trait TaskManagerProcessTrait
{
    /** @var TaskManagerProcess $taskManagerProcess */
    protected TaskManagerProcess $taskManagerProcess;

    /**
     * @return TaskManagerProcess
     */
    public function getTaskManagerProcess(): TaskManagerProcess
    {
        return $this->taskManagerProcess;
    }

    /**
     * @param TaskManagerProcess $taskManagerProcess
     * @return self
     */
    public function setTaskManagerProcess(TaskManagerProcess $taskManagerProcess): self
    {
        $this->taskManagerProcess = $taskManagerProcess;

        return $this;
    }
}
