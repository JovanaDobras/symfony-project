<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table('user_client')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName:"id", nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: "client_id", referencedColumnName:"id", nullable: false)]
    private $client;

    #[ORM\Column(type: 'datetime')]
    private $month;

    #[ORM\Column(type: 'time')]
    private $time;

    #[ORM\Column(type: 'string', length: 255)]
    private $taskName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getMonth(): ?\DateTimeInterface
    {
        return $this->month;
    }

    public function setMonth(\DateTimeInterface $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTaskName(): ?string
    {
        return $this->taskName;
    }

    public function setTaskName(string $taskName): self
    {
        $this->taskName = $taskName;

        return $this;
    }
}
