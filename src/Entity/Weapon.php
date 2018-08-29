<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeaponRepository")
 */
class Weapon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $minDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxItemCondition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMinDamage(): ?int
    {
        return $this->minDamage;
    }

    public function setMinDamage(int $minDamage): self
    {
        $this->minDamage = $minDamage;

        return $this;
    }

    public function getMaxDamage(): ?int
    {
        return $this->maxDamage;
    }

    public function setMaxDamage(int $maxDamage): self
    {
        $this->maxDamage = $maxDamage;

        return $this;
    }

    public function getMaxItemCondition(): ?int
    {
        return $this->maxItemCondition;
    }

    public function setMaxItemCondition(int $maxItemCondition): self
    {
        $this->maxItemCondition = $maxItemCondition;

        return $this;
    }
}
