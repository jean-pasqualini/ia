<?php

namespace Map\Player;
use IA\CatIA;
use Map\Location\Direction;
use Map\Location\Point;
use Map\Player\Chat\Estomac;
use Map\Render\NCurseRender;
use Map\World\World;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 11:37
 */
class Chat extends Player
{
    protected $position;

    protected $ia;

    protected $estomac;

    public function __construct()
    {
        $this->position = new Point(5, 5);

        $this->ia = new CatIA($this);

        $this->estomac = new Estomac($this);
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function move()
    {
        $this->position->move();
    }

    public function getIa()
    {
        return $this->ia;
    }

    public function update(World $world)
    {
        parent::update($world);

        //$key = ncurses_getch();

        $this->getPosition()->setDirection($world->getInputController()->getDirection());

        $this->estomac->update($world);
    }
}