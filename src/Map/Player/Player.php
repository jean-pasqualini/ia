<?php

namespace Map\Player;
use Map\World\World;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 11:37
 */
abstract class Player implements PlayerInterface
{
    protected $life = 10;

    protected $resistance = 0;

    protected $puissance = 1;

    public function getLife()
    {
        return $this->life;
    }

    public function setLife($life)
    {
        $this->life = $life;
    }

    public function attackBy(\GunInterface $gun)
    {
        $this->setLife($this->getLife() - ($gun->getPuissance() - $this->getResistance()));
    }

    public function attack(Player $player)
    {
        $this->attackBy($this);
    }

    public function getResistance()
    {
        return $this->resistance;
    }

    public function update(World $world)
    {
        if($this->life <= 1)
        {
            throw new \Exception("you are dead");
        }
    }
}