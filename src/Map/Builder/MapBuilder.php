<?php

namespace Map\Builder;
use Map\Location\Point;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:53
 */
class MapBuilder
{
    protected $map;

    const HERBE = "X";
    const ARBRE = "Y";
    const EAU = "E";
    const FLEUR = "F";

    protected static $allowedItems = array(
        self::HERBE,
        self::ARBRE,
        self::EAU,
        self::FLEUR
    );

    public function __construct($map)
    {
        $this->map = $this->transformRawMap($map);
    }

    public static function getAllowedItems()
    {
        return self::$allowedItems;
    }

    protected function transformRawMap($map)
    {
        $mapArray = array();

        foreach($map as $line)
        {
            $mapArray[] = str_split($line);
        }

        return $mapArray;
    }

    public function setItem(Point $position, $item)
    {
        $this->map[$position->getY()][$position->getX()] = $item;
    }

    public function getMap()
    {
        return $this->map;
    }
}