<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_time;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longtitude;

    /**
     * @ORM\Column(type="boolean")
     */
    private $done;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Route", inversedBy="deliveries")
     */
    private $route;

    public function __construct()
    {
        $this->createdAt = (new \DateTime('now'));
        $this->updatedAt = (new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientAddress(): ?string
    {
        return $this->client_address;
    }

    public function setClientAddress(string $client_address): self
    {
        $this->client_address = $client_address;

        return $this;
    }

    public function getDeliveryTime(): ?\DateTimeInterface
    {
        return $this->delivery_time;
    }

    public function setDeliveryTime(\DateTimeInterface $delivery_time): self
    {
        $this->delivery_time = $delivery_time;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongtitude(): ?float
    {
        return $this->longtitude;
    }

    public function setLongtitude(float $longtitude): self
    {
        $this->longtitude = $longtitude;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route): self
    {
        $this->route = $route;

        return $this;
    }
}
