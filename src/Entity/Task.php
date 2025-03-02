<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * class Task
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[Constraints\NotBlank]
    #[Constraints\Length(min: 1, max: 255)]
    #[ORM\Column(length: 255)]    protected ?string $title = null;

    #[ORM\Column(name: "is_done", options: ["default" => false])]
    protected bool $isDone = false;

    #[ORM\Column]
    protected DateTime $createdAt;

    #[ORM\Column]
    protected DateTime $updatedAt;

    #[ORM\Column(nullable: true)]
    protected ?DateTime $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return void
     */
    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function setId(int $id): Task
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle(string $title): Task
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @param bool $isDone
     * @return Task
     */
    public function setIsDone(bool $isDone): Task
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Task
     */
    public function setCreatedAt(DateTime $createdAt): Task
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Task
     */
    public function setUpdatedAt(DateTime $updatedAt): Task
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime $deletedAt
     * @return Task
     */
    public function setDeletedAt(DateTime $deletedAt): Task
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
