<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 27/12/15
 * Time: 17:29
 */

namespace Map\Render;


use CurseFramework\Cursor;
use CurseFramework\Ncurses;
use CurseFramework\Window;
use Map\Builder\MapBuilder;
use Map\Render\Curse\Map;

class NCurseRender extends Ncurses implements MapRenderInterface {

    protected $standardOutput;

    protected $window;

    protected $cursor;

    protected $map;

    public function __construct($line, $colonne)
    {
        parent::__construct();

        if(!extension_loaded("ncurses"))
        {
            throw new \Exception("curse not supported");
        }

        $this->window = new Window();
        $this->window->border();
        $this->window->getMaxYX($y, $x);

        $this->map = new Map($y/2, $x/2, ($y/2/2), ($x/2/2));
        $this->map->border();

        $this->cursor = new Cursor(0, 0, false);
        ncurses_keypad($this->window->getWindow(), true);
    }

    public function render($map)
    {
        $this->window->refresh();
        $this->map->draw($map);
        $this->map->refresh();
        usleep(100000);
    }
    public function clear($map)
    {
    }


}