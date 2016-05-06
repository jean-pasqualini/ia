<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 06/05/16
 * Time: 14:55
 */

namespace Map\Provider;

use Map\Builder\MapBuilder;


/**
 * EmptyMapProvider
 *
 * @author Jean Pasqualini <jean.pasqualini@digitaslbi.fr>
 * @copyright 2016 DigitasLbi France
 * @package Map\Provider;
 */
class EmptyMapProvider
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
        $line = $this->line;
        $colonne = $this->colonne;

        $map = array();

        for($i = 1; $i <= $line; $i++)
        {
            $mapLine = array();

            for($j = 1; $j <= $colonne; $j++)
            {
                $mapLine[] = 'V';
            }

            $map[] = implode("", $mapLine);
        }

        return $map;
    }
}