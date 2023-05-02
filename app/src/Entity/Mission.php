<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var ArrayCollection<Creature>
     *
     * @ORM\OneToMany(targetEntity="Creature", mappedBy="mission")
     */
    private Collection $creatures;

    public function __construct()
    {
        $this->difficulty = 10;
        $this->finished = false;
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
     * @return int
     */
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    /**
     * @param int $difficulty
     */
    public function setDifficulty(int $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
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

}
