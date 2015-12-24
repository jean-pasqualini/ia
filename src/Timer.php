<?php

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 14:50
 */
class Timer
{
    protected $tick = 0;

    public function update()
    {
        $this->tick++;
    }

    public function isTime($probabiltiy)
    {
        return $this->tick % $probabiltiy == 0;
    }
}