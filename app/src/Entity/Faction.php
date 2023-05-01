<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Faction
 *
 * @ORM\Table(name="factions")
 * @ORM\Entity
 */
class Faction
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
     * @ORM\Column(name="faction_name", type="string", length=128, nullable=false)
     */
    private string $factionName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private string $description;

    /**
     * @var Creature
     *
     * @ORM\OneToOne(targetEntity="Creature")
     */
    private Creature $leader;

    /**
     * @var ArrayCollection<Creature>
     *
     * @ORM\OneToMany(targetEntity="Creature", mappedBy="faction")
     */
    private Collection $creatures;

    public function __construct()
    {
        $this->creatures = new ArrayCollection();
    }

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
    public function getFactionName(): string
    {
        return $this->factionName;
    }

    /**
     * @param string $factionName
     */
    public function setFactionName(string $factionName): void
    {
        $this->factionName = $factionName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Creature
     */
    public function getLeader(): Creature
    {
        return $this->leader;
    }

    /**
     * @param Creature $leader
     */
    public function setLeader(Creature $leader): void
    {
        $this->leader = $leader;
    }

    /**
     * @return Collection
     */
    public function getCreatures(): Collection
    {
        return $this->creatures;
    }

    /**
     * @param Collection $creatures
     */
    public function setCreatures(Collection $creatures): void
    {
        $this->creatures = $creatures;
    }

    public function __toString(): string
    {
        return $this->getFactionName();
    }


}
