<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 14:01
 */

namespace IA;


use Map\World\World;
use Map\Player\Player;
use IA\IAInterface;

class ApplicationIA implements IAInterface
{
    public function __construct()
    {
    }

    public function update(World $world)
    {
        $players = $world->getPlayerCollection();

        foreach($players as $player)
        {
            /** @var $player Player */
            $player->getIa()->update($world);

            $player->update($world);
        }
    }
}