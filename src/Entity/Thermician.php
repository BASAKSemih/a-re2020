<?php

namespace App\Entity;

use App\Repository\ThermicianRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThermicianRepository::class)]
class Thermician
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $pendingTicket = 0;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToOne(inversedBy: 'thermician', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: 'integer')]
    private int $finishedTicket = 0;

    #[ORM\OneToOne(inversedBy: 'activeThermician', targetEntity: Ticket::class, cascade: ['persist', 'remove'])]
    private ?Ticket $activeTicket;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPendingTicket(): ?int
    {
        return $this->pendingTicket;
    }

    public function setPendingTicket(int $pendingTicket): self
    {
        $this->pendingTicket = $pendingTicket;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFinishedTicket(): ?int
    {
        return $this->finishedTicket;
    }

    public function setFinishedTicket(int $finishedTicket): self
    {
        $this->finishedTicket = $finishedTicket;

        return $this;
    }

    public function getActiveTicket(): ?Ticket
    {
        return $this->activeTicket;
    }

    public function setActiveTicket(?Ticket $activeTicket): self
    {
        $this->activeTicket = $activeTicket;

        return $this;
    }

}
