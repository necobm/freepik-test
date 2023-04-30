<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mission
 *
 * @ORM\Table(name="missions")
 * @ORM\Entity
 */
class Mission
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
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private string $description;

    /**
     * @var int
     *
     * Accepted values from 1 to 10
     * @ORM\Column(name="difficulty", type="integer", nullable=false)
     */
    private int $difficulty;

    /**
     * @var bool
     *
     *@ORM\Column(name="finished", type="boolean", nullable=false)
     */
    private bool $finished;

    public function __construct()
    {
        $this->difficulty = 10;
        $this->finished = false;
    }
}
