<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArmorRepository")
 */
class Armor
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
    private $defence;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxItemCondition;

    /**
     * @ORM\Column(type="integer")
     */
    private $levelAvailable;

    private $condition;

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

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;

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
    
    public function getLevelAvailable(): ?int
    {
        return $this->levelAvailable;
    }

    public function setLevelAvailable(int $levelAvailable): self
    {
        $this->levelAvailable = $levelAvailable;

        return $this;
    }

    public function getCondition(): ?int
    {
        return $this->condition;
    }

    public function setCondition(int $condition): self
    {
        $this->condition = $condition;

        return $this;
    }
}
