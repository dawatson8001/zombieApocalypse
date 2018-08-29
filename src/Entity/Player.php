<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
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
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxHealth;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weapon")
     */
    private $weapon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weaponCondition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Armor")
     */
    private $armor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $armorCondition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine")
     */
    private $medicineOne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine")
     */
    private $medicineTwo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getMaxHealth(): ?int
    {
        return $this->maxHealth;
    }

    public function setMaxHealth(int $maxHealth): self
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getWeaponCondition(): ?int
    {
        return $this->weaponCondition;
    }

    public function setWeaponCondition(?int $weaponCondition): self
    {
        $this->weaponCondition = $weaponCondition;

        return $this;
    }

    public function getArmor(): ?Armor
    {
        return $this->armor;
    }

    public function setArmor(?Armor $armor): self
    {
        $this->Armor = $armor;

        return $this;
    }

    public function getArmorCondition(): ?int
    {
        return $this->armorCondition;
    }

    public function setArmorCondition(?int $armorCondition): self
    {
        $this->armorCondition = $armorCondition;

        return $this;
    }

    public function getMedicineOne(): ?Medicine
    {
        return $this->medicineOne;
    }

    public function setMedicineOne(?Medicine $medicineOne): self
    {
        $this->medicineOne = $medicineOne;

        return $this;
    }

    public function getMedicineTwo(): ?Medicine
    {
        return $this->medicineTwo;
    }

    public function setMedicineTwo(?Medicine $medicineTwo): self
    {
        $this->medicineTwo = $medicineTwo;

        return $this;
    }
}
