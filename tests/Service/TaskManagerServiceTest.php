<?php

namespace App\Tests\Service;

use App\Entity\Task;
use App\Process\TaskManagerProcess;
use App\Repository\TaskRepository;
use App\Service\TaskManagerService;
use App\Tests\TestCase\AbstractApplicationTestCase;
use App\Traits\Service\TaskManagerServiceTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class TaskManagerServiceTest
 * @package App\Tests\Service
 */
class TaskManagerServiceTest extends AbstractApplicationTestCase
{
    use TaskManagerServiceTrait;

    /** @var MockObject $entityManagerMock */
    protected MockObject $entityManagerMock;

    /** @var MockObject $taskManagerProcessMock */
    protected MockObject $taskManagerProcessMock;

    /** @var TaskManagerService $taskManagerService */
    protected TaskManagerService $taskManagerService;

    /**
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->taskManagerProcessMock = $this->getMockBuilder(TaskManagerProcess::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->container->set(EntityManagerInterface::class, $this->entityManagerMock);
        $this->container->set(TaskManagerProcess::class, $this->taskManagerProcessMock);

        $this->taskManagerService = $this->container->get(TaskManagerService::class);
    }

    /**
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return void
     */
    #[DataProvider("provideTasksData")]
    public function testGetTasks(int $page, string $sort, string $direction): void
    {
        $expectedTasks = [new Task(), new Task()];
        $this->taskManagerProcessMock->expects($this->once())
            ->method("fetchTasks")
            ->with($page, $sort, $direction)
            ->willReturn($expectedTasks);

        $this->assertSame($expectedTasks, $this->taskManagerService->getTasks($page, $sort, $direction));
    }

    /**
     * @return array
     */
    public static function provideTasksData(): array
    {
        return [
            "default parameters" => [
                1,
                TaskRepository::DEFAULT_SORT_FIELD,
                TaskRepository::DEFAULT_SORT_DIRECTION,
                "default"
            ],
            "custom parameters" => [
                2,
                "created_at",
                "ASC",
                "custom"
            ],
        ];
    }

    /**
     * @return void
     */
    public function testCreateTask(): void
    {
        $task = (new Task())->setTitle("Test Task");
        $savedTask = new Task();
        $this->taskManagerProcessMock->expects($this->once())
            ->method("saveTask")
            ->willReturnCallback(function (Task $submittedTask) use ($savedTask, $task) {
                $this->assertEquals($task->getTitle(), $submittedTask->getTitle());
                return $savedTask;
            });

        $this->assertSame($savedTask, $this->taskManagerService->createTask($task));
    }

    /**
     * @param bool $initialIsDone
     * @param bool $expectedIsDone
     * @return void
     */
    #[DataProvider("provideTaskToggleData")]
    public function testToggleTask(bool $initialIsDone, bool $expectedIsDone): void
    {
        $task = (new Task())->setIsDone($initialIsDone);
        $savedTask = (new Task())->setIsDone($expectedIsDone);
        $this->taskManagerProcessMock->expects($this->once())
            ->method("saveTask")
            ->willReturnCallback(function (Task $submittedTask) use ($savedTask, $expectedIsDone) {
                $this->assertEquals($expectedIsDone, $submittedTask->getIsDone());
                return $savedTask;
            });

        $this->assertSame($savedTask, $this->taskManagerService->toggleTask($task));
    }

    /**
     * @return array
     */
    public static function provideTaskToggleData(): array
    {
        return [
            "toggle from false to true" => [false, true],
            "toggle from true to false" => [true, false],
        ];
    }

    /**
     * @return void
     */
    public function testDeleteTask(): void
    {
        $task = new Task();
        $savedTask = new Task();
        $this->taskManagerProcessMock->expects($this->once())
            ->method("saveTask")
            ->willReturnCallback(function (Task $submittedTask) use ($savedTask) {
                $this->assertNotNull($submittedTask->getDeletedAt());
                $this->assertInstanceOf(DateTime::class, $submittedTask->getDeletedAt());
                return $savedTask;
            });

        $this->assertSame($savedTask, $this->taskManagerService->deleteTask($task));
    }
}
