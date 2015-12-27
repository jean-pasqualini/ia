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

        $stdin = fopen('php://stdin', 'r');
        stream_set_blocking($stdin, false);
        stream_set_timeout($stdin, 0, 200);

        $key = fgets($stdin, 2);

            // No input right now
        if (!empty($key)) {
            switch($key)
            {
                case "q": //left
                    $this->getPosition()->setDirection(new Direction(-1, 0));
                    break;
                case "z": //upa
                    $this->getPosition()->setDirection(new Direction(0, -1));
                    break;
                case "d": //right
                    $this->getPosition()->setDirection(new Direction(1, 0));
                    break;
                case "s": //down
                    $this->getPosition()->setDirection(new Direction(0, 1));
                    break;
                default:
                    $this->getPosition()->setDirection(new Direction(0, 0));
                    break;
            }

        }

        $this->estomac->update($world);
    }
}