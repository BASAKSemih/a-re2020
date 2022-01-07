<?php

namespace App\Entity;

use App\Repository\ThermicianRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ThermicianRepository::class)]
class Thermician implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    /**
     * @var array<array-key, string>
     */
    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_THERMICIAN'];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToOne(mappedBy: 'activeThermician', targetEntity: Ticket::class, cascade: ['persist', 'remove'])]
    private ?Ticket $activeTicket;

    #[ORM\OneToMany(mappedBy: 'thermician', targetEntity: Remark::class)]
    private $remarks;

    #[ORM\OneToOne(mappedBy: 'oldThermician', targetEntity: Ticket::class, cascade: ['persist', 'remove'])]
    private $pendingTicket;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->remarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * * @return array<array-key, string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

//    public function setRoles(array $roles): self
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getActiveTicket(): ?Ticket
    {
        return $this->activeTicket;
    }

    public function setActiveTicket(?Ticket $activeTicket): self
    {
        // unset the owning side of the relation if necessary
        if ($activeTicket === null && $this->activeTicket !== null) {
            $this->activeTicket->setActiveThermician(null);
        }

        // set the owning side of the relation if necessary
        if ($activeTicket !== null && $activeTicket->getActiveThermician() !== $this) {
            $activeTicket->setActiveThermician($this);
        }

        $this->activeTicket = $activeTicket;

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getRemarks(): Collection
    {
        return $this->remarks;
    }

    public function addRemark(Remark $remark): self
    {
        if (!$this->remarks->contains($remark)) {
            $this->remarks[] = $remark;
            $remark->setThermician($this);
        }

        return $this;
    }

    public function removeRemark(Remark $remark): self
    {
        if ($this->remarks->removeElement($remark)) {
            // set the owning side to null (unless already changed)
            if ($remark->getThermician() === $this) {
                $remark->setThermician(null);
            }
        }

        return $this;
    }

    public function getPendingTicket(): ?Ticket
    {
        return $this->pendingTicket;
    }

    public function setPendingTicket(?Ticket $pendingTicket): self
    {
        // unset the owning side of the relation if necessary
        if ($pendingTicket === null && $this->pendingTicket !== null) {
            $this->pendingTicket->setOldThermician(null);
        }

        // set the owning side of the relation if necessary
        if ($pendingTicket !== null && $pendingTicket->getOldThermician() !== $this) {
            $pendingTicket->setOldThermician($this);
        }

        $this->pendingTicket = $pendingTicket;

        return $this;
    }
}
