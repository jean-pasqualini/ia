<?php
class Ncurses
{
    const XCURSES_KEY_LF    = 13;
    const XCURSES_KEY_CR    = 10;
    const XCURSES_KEY_ESC   = 27;
    const XCURSES_KEY_TAB   = 9;

    protected static $focus = null;

    public function __construct()
    {
        ncurses_init();
    }

    public function __destruct()
    {
        ncurses_end();
    }

    public static function setFocus( Window $window )
    {
        self::$focus = $window;
    }

    public static function getFocus()
    {
        return self::$focus;
    }
}
