<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\WeaponRepository;
use App\Entity\Weapon;
use App\Repository\ArmorRepository;
use App\Repository\MedicineRepository;
use App\Repository\EnemyRepository;
use App\Entity\Armor;
use App\Entity\Medicine;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Flex\Response;
use PhpParser\Node\Expr\AssignOp\Concat;
use App\Form\NewPlayerType;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{
    private $currentMoves;
    private $currentLevel;
    private $weapon;
    private $armor;
    private $medicine;

    public function __construct(EntityManagerInterface $entityManager, WeaponRepository $weaponRepository, 
                                ArmorRepository $armorRepository, MedicineRepository $medicineRepository, 
                                EnemyRepository $enemyRepository, PlayerRepository $playerRepository){

        $this->weaponRepository = $weaponRepository;
        $this->armorRepository = $armorRepository;
        $this->medicineRepository = $medicineRepository;
        $this->enemyRepository = $enemyRepository;
        $this->playerRepository = $playerRepository;
        $this->entityManager = $entityManager;
        $this->player = new Player();
    }

    /**
     * @Route("/", name="test_page")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(
            NewPlayerType::class,
            $this->player
        );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $this->player->setHealth(100);
            $this->player->setMaxHealth(100);
            $this->entityManager->persist($this->player);
            $this->entityManager->flush();

            return $this->redirectToRoute('move',[
                'username' => $this->player->getUsername(),
                'from' => 'N',
                'currentLevel' => 1,
                'currentMove' => 1,
            ]);

        }
        return $this->render('zombieApocalypse/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/start/{username}/{from}", name="start")
     */
    public function start(Player $player, $from)
    {
        $this->player->setUsername($player->getUsername());
        $this->currentLevel = 1;
        $this->currentMoves = 1;
        $this->equipment = null;
        $this->medicine = null;

        return $this->render('zombieApocalypse/board.html.twig', [
            'directions' => $this->availableDirection($from),
            'player' => $this->player,
            'moves' => $this->currentMoves,
            'level' => $this->currentLevel,
            'equipment' => $this->equipment,
            'medicine' => $this->medicine,
        ]);
    }

    /**
     * @Route("/move/{username}/{from}/{currentLevel}/{currentMove}", name="move")
     */
    public function move(Player $player, $from, $currentLevel, $currentMove)
    {
        $this->player = $player;
        $this->currentMoves = $currentMove + 1;
        $this->currentLevel = $currentLevel;
        $this->equipment = null;
        $this->medicine = null;

        return $this->render('zombieApocalypse/board.html.twig', [
            'directions' => $this->availableDirection($from),
            'player' => $this->player,
            'moves' => $this->currentMoves,
            'level' => $this->currentLevel,
            'equipment' => $this->equipment,
            'medicine' => $this->medicine,
        ]);
    }

    //Create possible directions available after changing rooms
    public function availableDirection($directionFrom)
    {
        $previousDirection = $directionFrom;

        $makeDirection = [];
        $directions = [];
        $makeDirection[0] = $previousDirection;
        for($x=1; $x <4; $x++){
            $dir = rand(1, 100);
            if(((rand(1, 100) + $this->currentMoves) > 100) && $x == 1){
                break;
            }
            switch($dir){
                case ($dir <= 25):
                    $makeDirection[$x] = 'N';
                    break;
                case ($dir <= 50):
                    $makeDirection[$x] = 'E';
                    break;
                case ($dir <= 75):
                    $makeDirection[$x] = 'S';
                    break;
                case ($dir <= 100):
                    $makeDirection[$x] = 'W';
                    break;
            }
        }
        $directions = array_unique($makeDirection);

        //disabled for testing
        if(sizeOf($directions) == 1){
            $situation = rand(1, 2);
            switch($situation){
                case 1:
                    return ['direction' => $directions,
                            'situation' => $this->deadEnd(),
                        ];
                    break;
                case 2:
                    return ['direction' => $directions,
                            'situation' => $this->findBedroom(),
                        ];
                    break;
            }
        }
        return ['direction' => $directions,
                'situation' => $this->situationInRoom(),
            ];
    }

    //Situation in room
    public function situationInRoom()
    {

        $situation = rand(1, 5);    //Testing 
        switch($situation){
            case 1:
                return $this->findWeapon();
                break;
            case 2:
                return $this->findArmor();
                break;
            case 3:
                return $this->findMedicine();
                break;
            case 4:
                if($this->player->getWeapon() != null){
                    return $this->findAttacker();
                }else{
                    return $this->emptyRoom();
                }
                break;
            case 5:
                return $this->emptyRoom();
                break;
            default:    //use to test functions
                return $this->findAttacker();
                break;
        }
    }

    public function findWeapon()
    {
        $statement = 'You enter into a new room, looking around you notice a new weapon on the floor,';
        $chanceOfFind = rand(1, (10 + ($this->currentLevel * 2)));
        if($chanceOfFind <= 5){
            $weapArr = $this->weaponRepository->findWeaponsByLevel($this->currentLevel);
            $weaponChoice = (rand(1, count($weapArr)) / $this->currentLevel) * rand(1, $this->currentMoves);
            for($x = count($weapArr) - 1; $x >= 0; $x--){
                if(($x === 0) || ($weaponChoice % $x === 0)){
                    $weapArr[$x]->setCondition(rand((ceil($weapArr[$x]->getMaxItemCondition() * 0.6)), $weapArr[$x]->getMaxItemCondition()));
                    $condition = $weapArr[$x]->getCondition();
                    if (($this->player->getWeapon() != null)) {
                        if ((($this->player->getWeapon()->getLevelAvailable() >= $weapArr[$x]->getLevelAvailable()) 
                                    && ($this->player->getWeaponCondition() > $weapArr[$x]->getCondition()))  
                            || (($this->player->getWeapon()->getLevelAvailable() > $weapArr[$x]->getLevelAvailable()))) {
                            $statement = $statement . ' it looks a bit worse for wear, better stick with what you have.';
                        }else {
                            $statement = $statement . ' looks like you would have more luck with this one.';
                            $this->changeWeapon($weapArr[$x], $condition);
                        }
                    }else {
                        $statement = $statement . ' looks like you would have more luck with this one.';
                        $this->changeWeapon($weapArr[$x], $condition);
                    }
                    $this->entityManager->flush();
                    $this->equipment = $weapArr[$x];
                    return ['statement' => $statement];
                }
            }
        }
        return $this->emptyRoom();
    }

    /**
     * @Route("/changeWeapon/{name}", name="change_weapon")
     */
    public function changeWeapon(Weapon $newWeapon, $condition)
    {
        $this->player->setWeapon($newWeapon);
        $this->player->setWeaponCondition($condition);
        return ;
    }

    /**
     * @Route("/updateWeapon/{condition}", name="update_weapon")
     */
    public function updateWeapon($condition)
    {
        $this->player->setWeaponCondition($condition);
        return;
    }

    public function findArmor()
    {
        $statement = 'You enter into a new room, looking around you notice some new armor on the floor,';
        $chanceOfFind = rand(1, (10 + ($this->currentLevel * 2)));
        if($chanceOfFind <= 5){
            $armorArr = $this->armorRepository->findArmorByLevel($this->currentLevel);
            $armorChoice = (rand(1, count($armorArr)) / $this->currentLevel) * rand(1, $this->currentMoves);
            for($x = count($armorArr) - 1; $x >= 0; $x--){
                if(($x === 0) || ($armorChoice % $x === 0)){
                    $armorArr[$x]->setCondition(rand((ceil($armorArr[$x]->getMaxItemCondition() * 0.6)), $armorArr[$x]->getMaxItemCondition()));
                    $condition = $armorArr[$x]->getCondition();
                    if (($this->player->getArmor() != null)) {
                        if ((($this->player->getArmor()->getLevelAvailable() >= $armorArr[$x]->getLevelAvailable()) 
                                    && ($this->player->getArmorCondition() > $armorArr[$x]->getCondition()))  
                            || (($this->player->getArmor()->getLevelAvailable() > $armorArr[$x]->getLevelAvailable()))) {
                            $statement = $statement . ' it looks a bit worse for wear, better stick with what you have.';
                        }else {
                            $statement = $statement . ' looks like you would have more luck with this one.';
                            $this->changeArmor($armorArr[$x], $condition);
                        }
                    }else {
                        $statement = $statement . ' looks like you would have more luck with this one.';
                        $this->changeArmor($armorArr[$x], $condition);
                    }
                    $this->entityManager->flush();
                    $this->equipment = $armorArr[$x];
                    return ['statement' => $statement];
                }
            }
        }
        return $this->emptyRoom();
    }

    /**
     * @Route("/changeArmor/{name}", name="change_armor")
     */
    public function changeArmor(Armor $newArmor, $condition)
    {
        $this->player->setArmor($newArmor);
        $this->player->setArmorCondition($condition);
        return;
    }

    /**
     * @Route("/updateArmor/{condition}", name="update_armor")
     */
    public function updateArmor($condition)
    {
        $this->player->setArmorCondition($condition);
        return;
    }

    public function findMedicine()
    {
        $statement = 'You enter into a new room, you peer into an open cupboard and find some medicine.';
        $chanceOfFind = rand(1, (10 + ($this->currentLevel * 2)));
        if($chanceOfFind <= 5){
            $medArr = $this->medicineRepository->findMedicinesByLevel($this->currentLevel);
            $medicineChoice = (rand(1, count($medArr)) / $this->currentLevel) * rand(1, $this->currentMoves);
            for($x = count($medArr) - 1; $x >= 0; $x--){
                if(($x === 0) || ($medicineChoice % $x === 0)){
                    $medArr[$x]->setUnits(rand((ceil($medArr[$x]->getMaxUnits() * 0.6)), $medArr[$x]->getMaxUnits()));
                    $units = $medArr[$x]->getUnits();
                    if (($this->player->getMedicineOne() != null) && ($this->player->getMedicineTwo() != null)) {
                        $medOnePower = $this->player->getMedicineOne()->getHealAmount() * $this->player->getMedicineOneUnits();
                        $medTwoPower = $this->player->getMedicineTwo()->getHealAmount() * $this->player->getMedicineTwoUnits();
                        $newMedPower = $medArr[$x]->getHealAmount() * $medArr[$x]->getUnits();
                        if($medOnePower < $newMedPower){
                            $statement = $statement . ' looks a bit better then what you have.';
                            $this->changeMedicineOne($medArr[$x], $units);
                        }elseif($medTwoPower < $newMedPower){
                            $statement = $statement . ' looks a bit better then what you have.';
                            $this->changeMedicineTwo($medArr[$x], $units);
                        }else {
                            $statement = $statement . ' looks like you already have some good medication.';
                        }
                    }elseif($this->player->getMedicineOne() === null) {
                        $statement = $statement . ' looks a bit better then what you have.';
                        $this->changeMedicineOne($medArr[$x], $units);
                    }elseif($this->player->getMedicineTwo() === null){
                        $statement = $statement . ' looks a bit better then what you have.';
                        $this->changeMedicineTwo($medArr[$x], $units);
                    }
                    $this->entityManager->flush();
                    $this->medicine = $medArr[$x];
                    return ['statement' => $statement];
                }
            }
        }
        return $this->emptyRoom();
    }

    /**
     * @Route("/changeMedicineOne/{name}", name="change_medicine_one")
     */
    public function changeMedicineOne(Medicine $newMedicine, $units)
    {
        $this->player->setMedicineOne($newMedicine);
        $this->player->setMedicineOneUnits($units);
        return;
    }

    /**
     * @Route("/updateMedicineOne/{units}", name="update_medicine_one")
     */
    public function updateMedicineOne($units)
    {
        --$units;
        $this->player->setMedicineOneUnits($units);
        return;
    }

    /**
     * @Route("/changeMedicineTwo/{name}", name="change_medicine_two")
     */
    public function changeMedicineTwo(Medicine $newMedicine, $units)
    {
        $this->player->setMedicineTwo($newMedicine);
        $this->player->setMedicineTwoUnits($units);
        return;
    }

    /**
     * @Route("/updateMedicineTwo/{units}", name="update_medicine_two")
     */
    public function updateMedicineTwo($units)
    {
        --$units;
        $this->player->setMedicineTwoUnits($units);
        return;
    }

    //get attacked by enemies
    public function findAttacker()
    {
        $statement = 'You carefully close the door behind you, as you turn around to inspect the room you hear noises!!';
        //search database for type of attacker, randomly generate number - all based on level and number of rooms visited in level
        return ['statement' => $statement];
    }

    //nothing to do in here
    public function emptyRoom()
    {
        $statement = 'Looks like there isn\'t anything to do in here';
        return ['statement' => $statement];
    }

    //find escape to next level
    public function deadEnd()
    {
        $statement = 'Looks like a dead end, but wait you notice '; 
        $exit = rand(1, 3);
        switch($exit){
            case 1:
                $statement = $statement . 'a stairwell through the window, you can use this to get to the next floor';
                break;
            case 2:
                $statement = $statement . 'an elevator door slightly open, you push it further and pull yourself up on top of the elevator, you can now reach the next floor';
            break;
            case 3:
                $statement = $statement . 'a ladder behind the door and a missing ceiling tile, you climb through and get to the next floor';
                break;
        }
        $this->currentLevel++;
        $this->currentMoves = 0;
        return ['statement' => $statement];
    }

    //find bed to rest in 
    public function findBedroom()
    {
        $statement = 'You enter the room, your tired eyes are immediately drawn to the cosy bed in the corner.';
        $recoveredHealth = rand(1, ($this->currentLevel * 10));
        if(($this->player->getHealth() + $recoveredHealth) >= 100){
            $statement = $statement . ' Your health is full again.';
            $this->player->setHealth(100);
        }else {
            $statement = $statement . ' You have recovered ' . $recoveredHealth . ' health.';
            $this->player->setHealth($this->player->getHealth() + $recoveredHealth);
        }
        $this->entityManager->flush();
        return ['statement' => $statement];
    }
}
