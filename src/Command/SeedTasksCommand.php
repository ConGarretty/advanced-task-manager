<?php

namespace App\Command;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * class SeedTasksCommand
 * @package App\Command
 * @NB: For example purposes only we are going to seed the database with sample tasks.
 */
#[AsCommand(name: "app:seed-tasks", description: "Seeds the database with sample tasks")]
class SeedTasksCommand extends Command
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tasks = [
            ["title" => "Complete project documentation", "isDone" => true],
            ["title" => "Review pull requests", "isDone" => false],
            ["title" => "Setup CI/CD pipeline", "isDone" => false],
            ["title" => "Write unit tests", "isDone" => false],
            ["title" => "Deploy to staging", "isDone" => true],
            ["title" => "Update dependencies", "isDone" => false],
            ["title" => "Refactor authentication", "isDone" => false],
            ["title" => "Optimize database queries", "isDone" => false],
            ["title" => "Fix security vulnerabilities", "isDone" => true],
            ["title" => "Implement new features", "isDone" => false],
            ["title" => "Update API documentation", "isDone" => false],
            ["title" => "Configure monitoring", "isDone" => true],
        ];

        foreach ($tasks as $taskData) {
            $task = new Task();
            $task->setTitle($taskData["title"]);
            $task->setIsDone($taskData["isDone"]);
            $this->entityManager->persist($task);
        }

        $this->entityManager->flush();
        $output->writeln("Tasks seeded successfully!");

        return Command::SUCCESS;
    }
}
