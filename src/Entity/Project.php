<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $company;

    #[ORM\Column(type: 'text')]
    private string $address;

    #[ORM\Column(type: 'string', length: 10)]
    private string $postalCode;

    #[ORM\Column(type: 'string', length: 255)]
    private string $city;

    #[ORM\Column(type: 'string', length: 255)]
    private string $phoneNumber;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $masterJob;

    #[ORM\Column(type: 'string', length: 255)]
    private string $cadastralReference;

    #[ORM\Column(type: 'string', length: 255)]
    private string $projectLocation;

    #[ORM\Column(type: 'string', length: 255)]
    private string $projectType;

    #[ORM\Column(type: 'date')]
    private DateTime $constructionPlanDate;

    #[ORM\OneToOne(inversedBy: 'project', targetEntity: Owner::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Owner $ownerProject;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMasterJob(): ?string
    {
        return $this->masterJob;
    }

    public function setMasterJob(string $masterJob): self
    {
        $this->masterJob = $masterJob;

        return $this;
    }

    public function getCadastralReference(): ?string
    {
        return $this->cadastralReference;
    }

    public function setCadastralReference(string $cadastralReference): self
    {
        $this->cadastralReference = $cadastralReference;

        return $this;
    }

    public function getProjectLocation(): ?string
    {
        return $this->projectLocation;
    }

    public function setProjectLocation(string $projectLocation): self
    {
        $this->projectLocation = $projectLocation;

        return $this;
    }

    public function getProjectType(): ?string
    {
        return $this->projectType;
    }

    public function setProjectType(string $projectType): self
    {
        $this->projectType = $projectType;

        return $this;
    }

    public function getConstructionPlanDate(): ?DateTime
    {
        return $this->constructionPlanDate;
    }

    public function setConstructionPlanDate(DateTime $constructionPlanDate): self
    {
        $this->constructionPlanDate = $constructionPlanDate;

        return $this;
    }

    public function getOwnerProject(): ?Owner
    {
        return $this->ownerProject;
    }

    public function setOwnerProject(Owner $ownerProject): self
    {
        $this->ownerProject = $ownerProject;

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
}