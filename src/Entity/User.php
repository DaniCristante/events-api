<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string[]
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $surnames;

    /**
     * @var Collection<Event>
     * @OneToMany(targetEntity="Event", mappedBy="owner")
     */
    private $owningEvents;

    /**
     * @var Collection<Event>
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="participants")
     */
    private $eventsParticipatingIn;

    public function __construct()
    {
        $this->owningEvents = new ArrayCollection();
        $this->eventsParticipatingIn = new ArrayCollection();
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

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @return array<string>
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /** @param array<string> $roles */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /** @see UserInterface */
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

    /** @see UserInterface */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurnames(): ?string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getOwningEvents(): Collection
    {
        return $this->owningEvents;
    }

    public function addOwningEvent(Event $event): self
    {
        $this->owningEvents[] = $event;

        return $this;
    }

    public function removeOwningEvent(Event $event): void
    {
        $this->owningEvents->removeElement($event);
    }

    /** @return Collection|Event[] */
    public function getEventsParticipatingIn(): Collection
    {
        return $this->eventsParticipatingIn;
    }

    public function addEventsParticipatingIn(Event $event): self
    {
        if (!$this->eventsParticipatingIn->contains($event)) {
            $this->eventsParticipatingIn[] = $event;
            $event->addParticipant($this);
        }

        return $this;
    }

    public function removeEventsParticipatingIn(Event $event): self
    {
        if ($this->eventsParticipatingIn->removeElement($event)) {
            $event->removeParticipant($this);
        }

        return $this;
    }
}
