<?php

namespace App\DataFixtures;

use App\Entity\Medicine;
use App\Entity\Armor;
use App\Entity\Weapon;
use App\Entity\Enemy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private const MEDICINES = [
        [
            'name' => 'Plaster',
            'healAmount' => 2,
            'maxUnits' => 10,
            'levelAvailable' => 1,
        ],
        [
            'name' => 'Bandage',
            'healAmount' => 4,
            'maxUnits' => 8,
            'levelAvailable' => 3,
        ],
        [
            'name' => 'Analgesic Cream',
            'healAmount' => 6,
            'maxUnits' => 8,
            'levelAvailable' => 5,
        ],
        [
            'name' => 'Antibiotics',
            'healAmount' => 10,
            'maxUnits' => 6,
            'levelAvailable' => 7,
        ],
        [
            'name' => 'Morphine Shot',
            'healAmount' => 70,
            'maxUnits' => 1,
            'levelAvailable' => 9,
        ],
    ];

    private const WEAPONS = [
        [
            'name' => 'Mop',
            'minDamage' => 5,
            'maxDamage' => 10,
            'maxItemCondition' => 10,
            'levelAvailable' => 1,
        ],
        [
            'name' => 'Metal Bar',
            'minDamage' => 10,
            'maxDamage' => 20,
            'maxItemCondition' => 20,
            'levelAvailable' => 3,
        ],
        [
            'name' => 'Fire Axe',
            'minDamage' => 20,
            'maxDamage' => 30,
            'maxItemCondition' => 20,
            'levelAvailable' => 5,
        ],
        [
            'name' => 'Handgun',
            'minDamage' => 25,
            'maxDamage' => 35,
            'maxItemCondition' => 25,
            'levelAvailable' => 6,
        ],
        [
            'name' => 'Shotgun',
            'minDamage' => 40,
            'maxDamage' => 60,
            'maxItemCondition' => 20,
            'levelAvailable' => 8,
        ],
        [
            'name' => 'Assault Rifle',
            'minDamage' => 40,
            'maxDamage' => 50,
            'maxItemCondition' => 100,
            'levelAvailable' => 10,
        ],
    ];

    private const ARMORS = [
        [
            'name' => 'Leather Jacket',
            'defence' => 20,
            'maxItemCondition' => 20,
            'levelAvailable' => 1,
        ],
        [
            'name' => 'Hazmat Suit',
            'defence' => 30,
            'maxItemCondition' => 10,
            'levelAvailable' => 3,
        ],
        [
            'name' => 'Bulletproof Vest',
            'defence' => 30,
            'maxItemCondition' => 40,
            'levelAvailable' => 6,
        ],
        [
            'name' => 'Riot Gear',
            'defence' => 50,
            'maxItemCondition' => 60,
            'levelAvailable' => 9,
        ],
    ];

    private const ENEMIES = [
        [
            'name' => 'Zombie',
            'health' => 20,
            'defence' => 10,
            'minDamage' => 5,
            'maxDamage' => 10,
            'levelAvailable' => 1,
        ],
        [
            'name' => 'Survivor',
            'health' => 10,
            'defence' => 0,
            'minDamage' => 2,
            'maxDamage' => 10,
            'levelAvailable' => 4,
        ],
        [
            'name' => 'Looter',
            'health' => 10,
            'defence' => 20,
            'minDamage' => 15,
            'maxDamage' => 25,
            'levelAvailable' => 8,
        ],
    ];
    
    public function __construct()
    {
    }
    public function load(ObjectManager $manager)
    {
        $this->loadMedicines($manager);
        $this->loadWeapons($manager);
        $this->loadArmors($manager);
        $this->loadEnemies($manager);
    }
    public function loadMedicines(ObjectManager $manager)
    {
        foreach (self::MEDICINES as $medicineData) {
            $medicine = new Medicine();
            $medicine->setName($medicineData['name']);
            $medicine->setHealAmount($medicineData['healAmount']);
            $medicine->setMaxUnits($medicineData['maxUnits']);
            $medicine->setLevelAvailable($medicineData['levelAvailable']);

            $manager->persist($medicine);
        }
        $manager->flush();
    }

    public function loadWeapons(ObjectManager $manager)
    {
        foreach (self::WEAPONS as $weaponData) {
            $weapon = new Weapon();
            $weapon->setName($weaponData['name']);
            $weapon->setMinDamage($weaponData['minDamage']);
            $weapon->setMaxDamage($weaponData['maxDamage']);
            $weapon->setMaxItemCondition($weaponData['maxItemCondition']);
            $weapon->setLevelAvailable($weaponData['levelAvailable']);

            $manager->persist($weapon);
        }
        $manager->flush();
    }

    public function loadArmors(ObjectManager $manager)
    {
        foreach (self::ARMORS as $armorData) {
            $armor = new Armor();
            $armor->setName($armorData['name']);
            $armor->setDefence($armorData['defence']);
            $armor->setMaxItemCondition($armorData['maxItemCondition']);
            $armor->setLevelAvailable($armorData['levelAvailable']);

            $manager->persist($armor);
        }
        $manager->flush();
    }

    public function loadEnemies(ObjectManager $manager)
    {
        foreach (self::ENEMIES as $enemyData) {
            $enemy = new Enemy();
            $enemy->setName($enemyData['name']);
            $enemy->setHealth($enemyData['health']);
            $enemy->setDefence($enemyData['defence']);
            $enemy->setMinDamage($enemyData['minDamage']);
            $enemy->setMaxDamage($enemyData['maxDamage']);
            $enemy->setLevelAvailable($enemyData['levelAvailable']);

            $manager->persist($enemy);
        }
        $manager->flush();
    }
}