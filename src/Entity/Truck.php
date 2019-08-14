<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 */
class Truck
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $registration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vendor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="float")
     */
    private $length;

    /**
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Route", mappedBy="truck")
     */
    private $route;

    public function __construct()
    {
        $this->createdAt = (new \DateTime('now'));
        $this->updatedAt = (new \DateTime('now'));
        $this->route = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(?string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return Collection|Route[]
     */
    public function getRoute(): Collection
    {
        return $this->route;
    }

    public function addRoute(Route $route): self
    {
        if (!$this->route->contains($route)) {
            $this->route[] = $route;
            $route->setTruck($this);
        }

        return $this;
    }

    public function removeRoute(Route $route): self
    {
        if ($this->route->contains($route)) {
            $this->route->removeElement($route);
            // set the owning side to null (unless already changed)
            if ($route->getTruck() === $this) {
                $route->setTruck(null);
            }
        }

        return $this;
    }
}
