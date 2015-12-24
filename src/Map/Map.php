<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:51
 */

namespace Map;


class Map
{
    protected $map;

    public function __construct($map)
    {
        $this->map = $map;
    }

    public function getMap()
    {
        return $this->map;
    }
}