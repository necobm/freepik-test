<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creature
 *
 * @ORM\Table(name="creatures")
 * @ORM\Entity
 */
class Creature
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
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private int $age;

    /**
     * @var Faction
     *
     * @ORM\ManyToOne(targetEntity="Faction", inversedBy="creatures")
     */
    private Faction $faction;

    /**
     * @var Weapon|null
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\Column(nullable=true)
     */
    private ?Weapon $mainWeapon;

    /**
     * @var Weapon|null
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\Column(nullable=true)
     */
    private ?Weapon $secondaryWeapon;

}
