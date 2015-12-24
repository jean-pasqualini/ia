<?php

namespace Map\Player;
use Map\Location\Point;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 11:37
 */
class Chat implements PlayerInterface
{
    protected $position;

    public function __construct()
    {
        $this->position = new Point(5, 5);
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function move()
    {
        $this->position->move();
    }
}