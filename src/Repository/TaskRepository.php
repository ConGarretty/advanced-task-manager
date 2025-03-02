<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class TaskRepository
 * @package App\Repository
 */
class TaskRepository extends ServiceEntityRepository
{
    public const DEFAULT_SORT_FIELD = "createdAt";
    public const DEFAULT_SORT_DIRECTION = "DESC";
    public const ASC_SORT_DIRECTION = "ASC";
    public const ITEMS_PER_PAGE = 5;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $page
     * @param string $sort
     * @param string $direction
     * @return array
     */
    public function findActiveTasks(int $page, string $sort, string $direction): array
    {
        return $this->findBy(
            ["deletedAt" => null],
            [$sort => $direction],
            self::ITEMS_PER_PAGE,
            ($page - 1) * self::ITEMS_PER_PAGE
        );
    }

    /**
     * @param Task $task
     * @param bool $flush
     * @return void
     */
    public function save(Task $task, bool $flush = true): void
    {
        $this->getEntityManager()->persist($task);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
