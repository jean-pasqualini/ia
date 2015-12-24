<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 11:42
 */

namespace Map\Location;


class Direction
{
    protected $x;

    protected $y;

    public function __construct($x, $y)
    {
        $this->x = $x;

        $this->y = $y;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }
}