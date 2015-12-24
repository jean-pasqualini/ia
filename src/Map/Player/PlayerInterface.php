<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 11:37
 */

namespace Map\Player;


interface PlayerInterface
{
    public function move();

    public function getPosition();
}