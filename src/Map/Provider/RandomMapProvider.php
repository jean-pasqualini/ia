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

    protected static $probabilityItem = array(
        MapBuilder::HERBE => 1,
        MapBuilder::ARBRE => 4,
        MapBuilder::EAU => 2,
        MapBuilder::FLEUR => 11
    );

    public function __construct($line, $colonne)
    {
        arsort(self::$probabilityItem);

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
                $mapLine[] = $this->findItem();
            }

            $map[] = implode("", $mapLine);
        }

        return $map;
    }

    public function findItem()
    {
        $number = rand(1, 100);

        foreach(self::$probabilityItem as $item => $probability)
        {
            if($number % $probability == 0)
            {
                return $item;
            }
        }

        throw new \Exception("aucun item avec une probabilité certaine");
    }
}