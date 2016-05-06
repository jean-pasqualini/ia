<?php

namespace Map\Builder;
use Map\Location\Point;
use Map\Provider\EmptyMapProvider;

/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:53
 */
class MapBuilder
{
    protected $map;

    protected $mapEmpty = array();

    protected $mapLayers = array();

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

        $this->mapEmpty = $this->map;
    }

    public function getMapLayer($layer)
    {
        if(!isset($this->mapLayers[$layer]))
        {
            $map = new EmptyMapProvider(count($this->map), count($this->map[0]));

            $mapBuilder = new MapBuilder($map->getMap());

            $this->mapLayers[$layer] = $mapBuilder;
        }

        return $this->mapLayers[$layer];
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

    public function findItemFromPoint(Point $point, $limit = 10)
    {
        $directions = array(
            "top" => array(
                "position" => new Point($point->getX(), $point->getY()),
                "move" => function(Point $point) {
                    $point->setY($point->getY() - 1);

                    return $point->getY() > 0;
                },
                "find" => 0
            ),
            "bottom" => array(
                "position" => new Point($point->getX(), $point->getY()),
                "move" => function(Point $point) {
                    $point->setY($point->getY() + 1);

                    return $point->getY() < count($this->map);
                },
                "find" => 0
            ),
            "left" => array(
                "position" => new Point($point->getX(), $point->getY()),
                "move" => function(Point $point) {
                    $point->setY($point->getX() - 1);

                    return $point->getX() > 0;
                },
                "find" => 0
            ),
            "right" => array(
                "position" => new Point($point->getX(), $point->getY()),
                "move" => function(Point $point) {
                    $point->setY($point->getX() + 1);

                    return $point->getX() < count($this->map[0]);
                },
                "find" => 0
            ),
        );

        // On regarde dans toute les direction
        foreach($directions as $direction)
        {
            $search = $direction['move']($direction['position']);


        }
    }

    public function removeItem($item)
    {
        $point = $this->findItem($item);

        if($point !== null) {
            $this->setItem($point, 'V');
        }
    }

    public function emptyMap()
    {
        $this->map = $this->mapEmpty;
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

    public function mergeWithParent($parentMap)
    {
        $mapFinal = $this->map;

        foreach($parentMap as $lineNumber => $lineElements)
        {
            $map = array_filter($this->map[$lineNumber], function($item)
            {
                return $item !== 'V';
            });

            $mapFinal[$lineNumber] = array_replace($parentMap[$lineNumber], $map);
        }

        return $mapFinal;
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

    public function debug($map = null)
    {
        $map = ($map) ? $map : $this->map;

        foreach($map as $line)
        {
            foreach($line as $item)
            {
                echo $item;
            }

            echo PHP_EOL;
        }

        echo PHP_EOL;
    }

    protected function mergeWithChildren($map)
    {
        foreach($this->mapLayers as $mapLayer)
        {
            $map = $mapLayer->mergeWithParent($map);
        }

        return $map;
    }

    public function setItem(Point $position, $item)
    {
        $this->map[$position->getY()][$position->getX()] = $item;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function getMapMerged()
    {
        $map = $this->map;

        $map = $this->mergeWithChildren($map);

        return $map;
    }
}