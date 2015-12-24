<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 14:41
 */

namespace Map\Player\Chat;


use Map\Player\Player;
use Map\World\World;

class Estomac
{
    protected $nouriture = 10;

    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function update(World $world)
    {
        if($this->nouriture == 0 && $world->getTimer()->isTime(1))
        {
            $this->player->setLife($this->player->getLife() - 1);

            return;
        }

        $this->nouriture--;
    }
}