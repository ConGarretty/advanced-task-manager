<?php

namespace App\Tests\Controller;

use App\Controller\TaskController;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\TaskManagerService;
use App\Tests\TestCase\AbstractApplicationTestCase;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TaskControllerTest
 * @package App\Tests\Controller
 */
class TaskControllerTest extends AbstractApplicationTestCase
{
    /** @var MockObject $taskManagerServiceMock */
    protected MockObject $taskManagerServiceMock;

    /** @var TaskController $taskController */
    protected TaskController $taskController;

    /**
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->taskManagerServiceMock = $this->createMock(TaskManagerService::class);
        $this->container->set(TaskManagerService::class, $this->taskManagerServiceMock);

        $this->controller = $this->container->get(TaskController::class);
    }

    /**
     * @return void
     */
    public function testIndexActionShouldReturnTaskList(): void
    {
        $tasks = [
            (new Task())->setId(1)->setTitle("Task 1"),
            (new Task())->setId(2)->setTitle("Task 2")
        ];
        $this->taskManagerServiceMock
            ->expects($this->once())
            ->method("getTasks")
            ->with(1, TaskRepository::DEFAULT_SORT_FIELD, TaskRepository::DEFAULT_SORT_DIRECTION)
            ->willReturn($tasks);

        $this->assertEquals(200, $this->controller->index(new Request())->getStatusCode());
    }

    /**
     * @return void
     */
    public function testToggleActionShouldToggleTaskStatus(): void
    {
        $task = (new Task())->setIsDone(false);
        $this->taskManagerServiceMock
            ->expects($this->once())
            ->method("toggleTask")
            ->with($task)
            ->willReturn($task->setIsDone(true));

        $response = $this->controller->toggle($task);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(["isDone" => true, "taskId" => null], json_decode($response->getContent(), true));
    }

    /**
     * @return void
     */
    public function testDeleteActionShouldDeleteTask(): void
    {
        $task = new Task();
        $this->taskManagerServiceMock
            ->expects($this->once())
            ->method("deleteTask")
            ->with($task);

        $this->assertEquals(200, $this->controller->delete($task, new Request())->getStatusCode());
    }
}
