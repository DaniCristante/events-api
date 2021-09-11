<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $maxEntries;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $currentEntries;

    /**
     * @var User
     * @ManyToOne(targetEntity="User", inversedBy="events")
     * @JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    public function __construct() {
        $this->currentEntries = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDatetime(): ?DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getMaxEntries(): ?int
    {
        return $this->maxEntries;
    }

    public function setMaxEntries(int $maxEntries): self
    {
        $this->maxEntries = $maxEntries;

        return $this;
    }

    public function getCurrentEntries(): ?int
    {
        return $this->currentEntries;
    }

    public function setCurrentEntries(?int $currentEntries): self
    {
        $this->currentEntries = $currentEntries;

        return $this;
    }

    public function setOwner(User $user): self
    {
        $this->owner = $user;
        $this->currentEntries += 1;

        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}
