<?php
namespace Map\World;
use IA\ApplicationIA;
use Map\Builder\MapBuilder;
use Timer;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 14:02
 */
class World
{
    protected $players;

    protected $map;

    protected $worldIA;

    protected $timer;

    public function __construct(MapBuilder $map, array $players = array())
    {
        $this->players = $players;

        $this->map = $map;

        $this->worldIA = new ApplicationIA();

        $this->timer = new Timer();
    }

    public function update()
    {
        $this->timer->update();

        $this->worldIA->update($this);
    }

    public function getTimer()
    {
        return $this->timer;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function getPlayerCollection()
    {
        return $this->players;
    }
}