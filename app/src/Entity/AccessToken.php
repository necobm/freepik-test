<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessToken
 *
 * @ORM\Table(name="access_tokens")
 * @ORM\Entity
 */
class AccessToken
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
     * @ORM\Column(name="token_value", type="string", length=255, nullable=false, unique=true)
     */
    private string $tokenValue;

    /**
     * @var string
     *
     * @ORM\Column(name="user_identification", type="string", length=128, nullable=false)
     */
    private string $userIdentification;


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
    public function getTokenValue(): string
    {
        return $this->tokenValue;
    }

    /**
     * @param string $tokenValue
     */
    public function setTokenValue(string $tokenValue): void
    {
        $this->tokenValue = $tokenValue;
    }

    /**
     * @return string
     */
    public function getUserIdentification(): string
    {
        return $this->userIdentification;
    }

    /**
     * @param string $userIdentification
     */
    public function setUserIdentification(string $userIdentification): void
    {
        $this->userIdentification = $userIdentification;
    }



}
