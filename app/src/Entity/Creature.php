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
     * @var Faction|null
     *
     * @ORM\ManyToOne(targetEntity="Faction", inversedBy="creatures")
     * @ORM\JoinColumn(nullable=true, name="faction_id")
     */
    private ?Faction $faction;

    /**
     * @var Weapon|null
     *
     * @ORM\ManyToOne(targetEntity="Weapon")
     * @ORM\JoinColumn(nullable=true, name="weapon_id")
     */
    private ?Weapon $weapon;

    /**
     * @var Mission|null
     *
     * @ORM\ManyToOne(targetEntity="Mission", inversedBy="creatures")
     * @ORM\JoinColumn(nullable=true, name="mission_id")
     */
    private ?Mission $mission;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_faction_leader", type="boolean")
     */
    private bool $factionLeader = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return Faction|null
     */
    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    /**
     * @param Faction|null $faction
     */
    public function setFaction(?Faction $faction): void
    {
        $this->faction = $faction;
    }

    /**
     * @return Weapon|null
     */
    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    /**
     * @param Weapon|null $weapon
     */
    public function setWeapon(?Weapon $weapon): void
    {
        $this->weapon = $weapon;
    }

    /**
     * @return Mission|null
     */
    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    /**
     * @param Mission|null $mission
     */
    public function setMission(?Mission $mission): void
    {
        $this->mission = $mission;
    }

    /**
     * @return bool
     */
    public function isFactionLeader(): bool
    {
        return $this->factionLeader;
    }

    /**
     * @param bool $factionLeader
     */
    public function setFactionLeader(bool $factionLeader): void
    {
        $this->factionLeader = $factionLeader;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

}
