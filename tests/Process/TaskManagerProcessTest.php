<?php

namespace App\Tests\Process;

use App\Entity\Task;
use App\Process\TaskManagerProcess;
use App\Repository\TaskRepository;
use App\Tests\TestCase\AbstractApplicationTestCase;
use App\Traits\Process\TaskManagerProcessTrait;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class TaskManagerProcessTest
 * @package App\Tests\Process
 */
class TaskManagerProcessTest extends AbstractApplicationTestCase
{
    use TaskManagerProcessTrait;

    /** @var MockObject $taskRepositoryMock */
    protected MockObject $taskRepositoryMock;

    /** @var TaskManagerProcess $taskManagerProcess */
    protected TaskManagerProcess $taskManagerProcess;

    /**
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->taskRepositoryMock = $this->getMockBuilder(TaskRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->container->set(TaskRepository::class, $this->taskRepositoryMock);

        $this->taskManagerProcess = $this->container->get(TaskManagerProcess::class);
    }

    /**
     * @return void
     */
    public function testFetchTasks(): void
    {
        $expectedTasks = [new Task(), new Task()];
        $this->taskRepositoryMock->expects($this->once())
            ->method("findActiveTasks")
            ->with(1, "title", TaskRepository::DEFAULT_SORT_DIRECTION)
            ->willReturn($expectedTasks);

        $this->assertSame(
            $expectedTasks,
            $this->taskManagerProcess->fetchTasks(1, "title", TaskRepository::DEFAULT_SORT_DIRECTION)
        );
    }

    /**
     * @return void
     */
    public function testSaveTask(): void
    {
        $task = new Task();
        $this->taskRepositoryMock->expects($this->once())->method("save")->with($task);

        $this->assertSame($task, $this->taskManagerProcess->saveTask($task));
    }
}
