<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbSeats = null;

    #[ORM\Column]
    private ?int $nbDoors = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $cost = null;

    #[ORM\ManyToOne]
    private ?CarCategory $category = null;

    public function __construct(){
        $this->nbDoors = 5;
        $this->nbSeats = 5;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbSeats(): ?int
    {
        return $this->nbSeats;
    }

    public function setNbSeats(int $nbSeats): self
    {
        $this->nbSeats = $nbSeats;

        return $this;
    }

    public function getNbDoors(): ?int
    {
        return $this->nbDoors;
    }

    public function setNbDoors(int $nbDoors): self
    {
        $this->nbDoors = $nbDoors;

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

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCategory(): ?CarCategory
    {
        return $this->category;
    }

    public function setCategory(?CarCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
