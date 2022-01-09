<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TicketRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'ticket', targetEntity: Project::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Project $project;

    #[ORM\OneToOne(inversedBy: 'activeTicket', targetEntity: Thermician::class, cascade: ['persist', 'remove'])]
    private ?Thermician $activeThermician;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\ManyToOne(targetEntity: Thermician::class, inversedBy: 'pendingTicket')]
    private ?Thermician $oldThermician;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getActiveThermician(): ?Thermician
    {
        return $this->activeThermician;
    }

    public function setActiveThermician(null|Thermician $activeThermician): self
    {
        $this->activeThermician = $activeThermician;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getOldThermician(): ?Thermician
    {
        return $this->oldThermician;
    }

    public function setOldThermician(?Thermician $oldThermician): self
    {
        $this->oldThermician = $oldThermician;

        return $this;
    }
}
