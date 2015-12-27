<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 27/12/15
 * Time: 12:25
 */

namespace Command;


use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Output\Output;

class NCursesOutput extends Output {

    protected $window;

    public function __construct()
    {
        parent::__construct();

        $this->setFormatter(new OutputFormatter());

        ncurses_init();

        //ncurses_mvaddstr(55,1,"My first ncurses application");

        $this->window = ncurses_newwin(40, 30, 0, 0);

        ncurses_wborder($this->window, 0,0 , 0,0 , 0,0 , 0,0);
    }

    public function __destruct()
    {
        ncurses_end();
    }

    /**
     * Writes a message to the output.
     *
     * @param string $message A message to write to the output
     * @param bool $newline Whether to add a newline or not
     */
    protected function doWrite($message, $newline)
    {
        //$message = "lol";

        $message = strip_tags($message);

        //ncurses_waddstr($this->window, $message, count($message));

        if($newline)
        {
            ncurses_getyx(STDSCR, $curx, $cury);

            ncurses_move($cury + 1, 0);
            ncurses_wrefresh($this->window);
           // ncurses_addchnstr("\n", 1);
           //
           //
        }
    }

    public function flush()
    {
        ncurses_wrefresh($this->window);
    }

    public function clear()
    {
        sleep(1);

        ncurses_clear();
    }
}