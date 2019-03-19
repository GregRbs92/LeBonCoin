<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OtherRepository")
 */
class Other extends Ad
{
    protected $type = 'other';
}
