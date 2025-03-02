<?php

namespace App\Service;

use App\Repository\TaskRepository;

/**
 * Class TaskMetaDataService
 * @package App\Service
 */
class TaskMetaDataService
{
    /**
     * @param int $page
     * @param array $tasks
     * @param string $sort
     * @param string $direction
     * @return array
     */
    public function prepareTasksWithMetaData(
        array $tasks,
        int $page,
        string $sort = TaskRepository::DEFAULT_SORT_FIELD,
        string $direction = TaskRepository::DEFAULT_SORT_DIRECTION
    ): array {
        return [
            "tasks" => $tasks,
            "sorting" => [
                "currentField" => $sort,
                "currentDirection" => $direction,
                "nextDirection" => $direction === TaskRepository::ASC_SORT_DIRECTION ?
                    TaskRepository::DEFAULT_SORT_DIRECTION : TaskRepository::ASC_SORT_DIRECTION,
            ],
            "pagination" => [
                "currentPage" => $page,
                "hasPrevious" => $page > 1,
                "hasNext" => count($tasks) >= TaskRepository::ITEMS_PER_PAGE,
                "sort" => $sort,
                "direction" => $direction
            ]
        ];
    }
}
