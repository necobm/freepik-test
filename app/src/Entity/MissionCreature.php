<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MissionCreature
 *
 * @ORM\Table(name="mission_creature")
 * @ORM\Entity
 */
class MissionCreature
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
     * @var Mission
     *
     * @ORM\ManyToOne(targetEntity="Mission")
     */
    private Mission $mission;

    /**
     * @var Creature
     *
     * @ORM\ManyToOne(targetEntity="Creature")
     */
    private Creature $creature;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_leader", type="boolean", nullable=false)
     */
    private bool $isLeader;

}
