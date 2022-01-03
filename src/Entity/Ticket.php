<?php

namespace App\Entity;

use App\Repository\TicketRepository;
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

    #[ORM\OneToOne(mappedBy: 'activeTicket', targetEntity: Thermician::class, cascade: ['persist', 'remove'])]
    private ?Thermician $activeThermician;

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

    public function setActiveThermician(?Thermician $activeThermician): self
    {
        // unset the owning side of the relation if necessary
        if ($activeThermician === null && $this->activeThermician !== null) {
            $this->activeThermician->setActiveTicket(null);
        }

        // set the owning side of the relation if necessary
        if ($activeThermician !== null && $activeThermician->getActiveTicket() !== $this) {
            $activeThermician->setActiveTicket($this);
        }

        $this->activeThermician = $activeThermician;

        return $this;
    }
}
