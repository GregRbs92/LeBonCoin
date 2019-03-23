<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job extends Ad
{
    protected $type = 'job';

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"full_ad"})
     */
    private $contractType;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"full_ad"})
     */
    private $salary;

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }
}
