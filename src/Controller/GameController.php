<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    private $currentLevel;
    private $currentMoves;

    /**
     * @Route("/", name="test_page")
     */
    public function index()
    {

        return $this->render('zombieApocalypse/index.html.twig');
    }

    /**
     * @Route("/move/{from}/{level}/{move}", name="move")
     */
    public function move($from, $level, $move)
    {
        $this->currentLevel = $level;
        $this->currentMoves = $move;

        return $this->render('zombieApocalypse/board.html.twig', [
            'directions' => $this->availableDirection($from),
        ]);
    }

    //Create possible directions available after changing rooms
    public function availableDirection($directionFrom)
    {
        //test variables to pass to the function
        $previousDirection = $directionFrom;

        //
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

        $situation = rand(1, 5);
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
                return $this->findAttacker();
                break;
            case 5:
                return $this->emptyRoom();
                break;
        }
    }

    public function findWeapon()
    {
        //add database for types and condition - type based on current level, condition is random based on level
        $chanceOfFind = rand(1, (10 + ($this->currentLevel* 2)));
        if($chanceOfFind <= 5){
            $weapon = 'Knife';
            return ['statement' => 'You enter into a new room, looking around you notice a new weapon.',
                    'item' => $weapon];
        }


        return ['statement' => 'You enter into a new room, looking around you notice a new weapon on the floor, as you pick it up you notice its been damaged beyond use.',
                'item' => ''];
    }

    public function findArmor()
    {
        //add database for types and condition - type based on current level, condition is random based on level
        $armor = 'Riot Gear';

        return ['statement' => 'You enter into a new room, looking around you notice some new armor ', 
                'item' => $armor];
    }

    public function findMedicine()
    {
        //add database for types of medicine and amount - based on current level
        $medicine = 'Paracetemol';

        return ['statement' => 'You enter into a new room, you peer into an open cupboard and find some medicine ',
                'item' => $medicine];
    }

    public function findAttacker()
    {
        //search database for type of attacker, randomly generate number - all based on level and number of rooms visited in level
        return ['statement' => 'You carefully close the door behind you, as you turn around to inspect the room you hear noises!!',
                'item' => ''];
    }

    public function emptyRoom()
    {
        return ['statement' => 'Looks like there isn\'t anything to do in here',
                'item' => ''];
    }

    public function deadEnd()
    {
        //create random chance of finding escape - through window to emergency stairwell, elevator shaft, ladders leading to open ceiling 
        return ['statement' => 'Looks like this is a dead end!',
                'item' => ''];
    }

    public function findBedroom()
    {
        //add resting amount - depends on level and random number generator for comfort
        return ['statement' => 'You enter the room, your tied eyes are immediately drawn to the cosy bed in the corner.',
                'item' => ''];
    }
}
