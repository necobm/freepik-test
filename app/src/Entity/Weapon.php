<?php

namespace App\Entity;

use App\Entity\ValueObject\WeaponPower;
use Doctrine\ORM\Mapping as ORM;

/**
 * Weapon
 *
 * @ORM\Table(name="weapons")
 * @ORM\Entity
 */
class Weapon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=false, unique=true)
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private string $description;

    /** @ORM\Embedded(class = WeaponPower::class, columnPrefix = false) */
    private WeaponPower $power;

    public function __construct()
    {
        $this->power = new WeaponPower(portability: 1,damage: 1,resistance: 1);
    }
}
