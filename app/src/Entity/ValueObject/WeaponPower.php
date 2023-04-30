<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class WeaponPower
{
    /** @ORM\Column(type="integer") */
    public int $portability;

    /** @ORM\Column(type="integer") */
    public int $damage;

    /** @ORM\Column(type="integer") */
    public int $resistance;

    /**
     * @param int $portability
     * @param int $damage
     * @param int $resistance
     */
    public function __construct(int $portability, int $damage, int $resistance)
    {
        $this->portability = $portability;
        $this->damage = $damage;
        $this->resistance = $resistance;
    }
}