<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle extends Ad
{
    protected $type = 'vehicle';

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"full_ad"})
     */
    private $fuelType;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"full_ad"})
     */
    private $price;

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
