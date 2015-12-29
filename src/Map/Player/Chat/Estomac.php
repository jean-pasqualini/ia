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
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Estomac
{
    protected $nouriture = 10;

    protected $player;

    protected $eventDispatcher;

    public function __construct(Player $player)
    {
        $this->player = $player;

        $this->eventDispatcher = new EventDispatcher();
    }

    public function update(World $world)
    {
        if($this->nouriture == 0 && $world->getTimer()->isTime(1))
        {
            $this->getEventDispatcher()->dispatch("hungry", new Event());

            //$this->player->setLife($this->player->getLife() - 1);

            return;
        }

        $this->nouriture--;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function __sleep()
    {
        return array(
            "nouriture",
            "player"
        );
    }
}