<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 27/12/15
 * Time: 20:16
 */

namespace Map\Render\Curse;


use CurseFramework\Window;

class Timer extends Window {

    public function draw()
    {
        ncurses_wmove($this->getWindow(), 1, 1);
        ncurses_waddstr($this->getWindow(), date("H:i:s"));
    }
}