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

    public function findItem($item)
    {
        foreach($this->map as $y => $line)
        {
            foreach($line as $x => $colonne)
            {
                if($this->map[$y][$x] == $item)
                {
                    return new Point($x, $y);
                }
            }
        }

        return null;
    }

    public function getItem(Point $position)
    {
        return $this->map[$position->getY()][$position->getX()];
    }

    public function crop($x, $y)
    {
        $this->map = array_slice($this->map, 0, $y);

        foreach($this->map as $line)
        {
            foreach($line as $colonne)
            {
                $this->map[$y] = array_slice($this->map[$y], 0, $x);
            }
        }
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