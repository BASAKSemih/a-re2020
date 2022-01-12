<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'document', targetEntity: Ticket::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Ticket $ticket;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameOne;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameTwo;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameThree;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameFourth;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nameFive;

    #[ORM\Column(type: 'string', length: 255)]
    private string $pathOne;

    #[ORM\Column(type: 'string', length: 255)]
    private string $pathTwo;

    #[ORM\Column(type: 'string', length: 255)]
    private string $pathThree;

    #[ORM\Column(type: 'string', length: 255)]
    private string $pathFourth;

    #[ORM\Column(type: 'string', length: 255)]
    private string $pathFive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getNameOne(): ?string
    {
        return $this->nameOne;
    }

    public function setNameOne(string $nameOne): self
    {
        $this->nameOne = $nameOne;

        return $this;
    }

    public function getNameTwo(): ?string
    {
        return $this->nameTwo;
    }

    public function setNameTwo(string $nameTwo): self
    {
        $this->nameTwo = $nameTwo;

        return $this;
    }

    public function getNameThree(): ?string
    {
        return $this->nameThree;
    }

    public function setNameThree(string $nameThree): self
    {
        $this->nameThree = $nameThree;

        return $this;
    }

    public function getNameFourth(): ?string
    {
        return $this->nameFourth;
    }

    public function setNameFourth(string $nameFourth): self
    {
        $this->nameFourth = $nameFourth;

        return $this;
    }

    public function getNameFive(): ?string
    {
        return $this->nameFive;
    }

    public function setNameFive(string $nameFive): self
    {
        $this->nameFive = $nameFive;

        return $this;
    }

    public function getPathOne(): ?string
    {
        return $this->pathOne;
    }

    public function setPathOne(string $pathOne): self
    {
        $this->pathOne = $pathOne;

        return $this;
    }

    public function getPathTwo(): ?string
    {
        return $this->pathTwo;
    }

    public function setPathTwo(string $pathTwo): self
    {
        $this->pathTwo = $pathTwo;

        return $this;
    }

    public function getPathThree(): ?string
    {
        return $this->pathThree;
    }

    public function setPathThree(string $pathThree): self
    {
        $this->pathThree = $pathThree;

        return $this;
    }

    public function getPathFourth(): ?string
    {
        return $this->pathFourth;
    }

    public function setPathFourth(string $pathFourth): self
    {
        $this->pathFourth = $pathFourth;

        return $this;
    }

    public function getPathFive(): ?string
    {
        return $this->pathFive;
    }

    public function setPathFive(string $pathFive): self
    {
        $this->pathFive = $pathFive;

        return $this;
    }

}
