<?php

namespace App\Tests\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\TaskMetaDataService;
use App\Tests\TestCase\AbstractApplicationTestCase;
use App\Traits\Service\TaskMetaDataServiceTrait;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Class TaskMetaDataServiceTest
 * @package App\Tests\Service
 */
class TaskMetaDataServiceTest extends AbstractApplicationTestCase
{
    use TaskMetaDataServiceTrait;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->taskMetaDataService = $this->container->get(TaskMetaDataService::class);
    }

    /**
     * @param array $tasks
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @param array $expectedResult
     * @return void
     */
    #[DataProvider("provideTaskMetaData")]
    public function testPrepareTasksWithMetaData(
        array $tasks,
        int $page,
        string $sort,
        string $direction,
        array $expectedResult
    ): void {
        $result = $this->taskMetaDataService->prepareTasksWithMetaData($tasks, $page, $sort, $direction);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public static function provideTaskMetaData(): array
    {
        $taskList = array_fill(0, TaskRepository::ITEMS_PER_PAGE, new Task());
        $lessThanDefaultTaskList = array_fill(0, TaskRepository::ITEMS_PER_PAGE - 3, new Task());

        return [
            "first page with full/ default items" => [
                $taskList,
                1,
                TaskRepository::DEFAULT_SORT_FIELD,
                TaskRepository::DEFAULT_SORT_DIRECTION,
                [
                    "tasks" => $taskList,
                    "sorting" => [
                        "currentField" => TaskRepository::DEFAULT_SORT_FIELD,
                        "currentDirection" => TaskRepository::DEFAULT_SORT_DIRECTION,
                        "nextDirection" => TaskRepository::ASC_SORT_DIRECTION,
                    ],
                    "pagination" => [
                        "currentPage" => 1,
                        "hasPrevious" => false,
                        "hasNext" => true,
                        "sort" => TaskRepository::DEFAULT_SORT_FIELD,
                        "direction" => TaskRepository::DEFAULT_SORT_DIRECTION
                    ]
                ]
            ],
            "second page with less items" => [
                $lessThanDefaultTaskList,
                2,
                "created_at",
                TaskRepository::ASC_SORT_DIRECTION,
                [
                    "tasks" => $lessThanDefaultTaskList,
                    "sorting" => [
                        "currentField" => "created_at",
                        "currentDirection" => TaskRepository::ASC_SORT_DIRECTION,
                        "nextDirection" => TaskRepository::DEFAULT_SORT_DIRECTION,
                    ],
                    "pagination" => [
                        "currentPage" => 2,
                        "hasPrevious" => true,
                        "hasNext" => false,
                        "sort" => "created_at",
                        "direction" => TaskRepository::ASC_SORT_DIRECTION
                    ]
                ]
            ]
        ];
    }
}
