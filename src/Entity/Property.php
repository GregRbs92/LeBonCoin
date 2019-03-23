<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property extends Ad
{
    protected $type = 'property';

    /**
     * @ORM\Column(type="integer")
     * @Groups({"full_ad"})
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"full_ad"})
     */
    private $price;

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

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
