<?php
namespace Map\World;
use IA\ApplicationIA;
use InputController\KeyboardInputController;
use Map\Builder\MapBuilder;
use Memory\MemoryManager;
use Snapshot\Instant;
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

    protected $memoryManager;

    protected $inputController;

    public function __construct(MapBuilder $map, array $players = array())
    {
        $this->players = $players;

        $this->map = $map;

        $this->worldIA = new ApplicationIA();

        $this->timer = new Timer();

        $this->memoryManager = new MemoryManager();

        $this->inputController = new KeyboardInputController();
    }

    public function getMemoryManager()
    {
        return $this->memoryManager;
    }

    public function getInputController()
    {
        return $this->inputController;
    }

    public function update()
    {
        $this->timer->update();

        $this->inputController->update();

        $this->worldIA->update($this);

        $this->memoryManager->getFlashMemory()->addInstant(new Instant($this));
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