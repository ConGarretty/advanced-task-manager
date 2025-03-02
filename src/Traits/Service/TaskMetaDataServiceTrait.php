<?php

namespace App\Traits\Service;

use App\Service\TaskMetaDataService;

/**
 * Class TaskMetaDataServiceTrait
 * @package App\Traits\Service
 */
trait TaskMetaDataServiceTrait
{
    /** @var TaskMetaDataService $taskMetaDataService */
    protected TaskMetaDataService $taskMetaDataService;

    /**
     * @return TaskMetaDataService
     */
    public function getTaskMetaDataService(): TaskMetaDataService
    {
        return $this->taskMetaDataService;
    }

    /**
     * @param TaskMetaDataService $taskMetaDataService
     * @return self
     */
    public function setTaskMetaDataService(TaskMetaDataService $taskMetaDataService): self
    {
        $this->taskMetaDataService = $taskMetaDataService;

        return $this;
    }
}
