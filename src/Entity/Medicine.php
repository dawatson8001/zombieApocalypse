<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicineRepository")
 */
class Medicine
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
    private $healAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxUnits;

    /**
     * @ORM\Column(type="integer")
     */
    private $levelAvailable;

    private $units;

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

    public function getHealAmount(): ?int
    {
        return $this->healAmount;
    }

    public function setHealAmount(int $healAmount): self
    {
        $this->healAmount = $healAmount;

        return $this;
    }

    public function getMaxUnits(): ?int
    {
        return $this->maxUnits;
    }

    public function setMaxUnits(int $maxUnits): self
    {
        $this->maxUnits = $maxUnits;

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

    public function getUnits(): ?int
    {
        return $this->units;
    }

    public function setUnits(int $units): self
    {
        $this->units = $units;

        return $this;
    }
}
