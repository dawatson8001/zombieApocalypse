<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnemyRepository")
 */
class Enemy
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
    private $health;

    /**
     * @ORM\Column(type="integer")
     */
    private $defence;

    /**
     * @ORM\Column(type="integer")
     */
    private $minDamage;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxDamage;

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

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;

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
}
