<?php

namespace App\Entity;

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
     * @var string
     *
     * @ORM\Column(name="leader", type="text", length=65535, nullable=false)
     */
    private string $leader;


}
