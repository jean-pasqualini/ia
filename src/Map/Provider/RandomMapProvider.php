<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:34
 */

namespace Map\Provider;


use Map\Builder\MapBuilder;

class RandomMapProvider
{
    protected $line;

    protected $colonne;

    public function __construct($line, $colonne)
    {
        $this->line = $line;

        $this->colonne = $colonne;
    }

    public function getMap()
    {
        $items = MapBuilder::getAllowedItems();

        $line = $this->line;
        $colonne = $this->colonne;

        $map = array();

        for($i = 1; $i <= $line; $i++)
        {
            $mapLine = array();

            for($j = 1; $j <= $colonne; $j++)
            {
                $mapLine[] = $items[array_rand($items)];
            }

            $map[] = implode("", $mapLine);
        }

        return $map;
    }
}