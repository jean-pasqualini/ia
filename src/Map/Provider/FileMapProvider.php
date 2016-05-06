<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 29/12/15
 * Time: 18:51
 */

namespace Map\Provider;


use Map\Builder\MapBuilder;

function mb_str_split($string,$string_length=1,$charset='utf-8') {
    if(mb_strlen($string,$charset)>$string_length || !$string_length) {
        do {
            $c = mb_strlen($string,$charset);
            $parts[] = mb_substr($string,0,$string_length,$charset);
            $string = mb_substr($string,$string_length,$c-$string_length,$charset);
        }while(!empty($string));
    } else {
        $parts = array($string);
    }
    return $parts;
}



class FileMapProvider {

    protected $file;

    public function __construct($file)
    {
        $this->file = new \SplFileObject($file, "r+");
    }

    public function getMap()
    {
        $lines = array();

        while(!$this->file->eof())
        {
            $lineFile = $this->file->fgets();

            //throw new \Exception(utf8_decode($lineFile));

            $lines[] = implode("", array_map(function($item) {
                return $this->format($item);
            }, mb_str_split($lineFile)));
        }

        return $lines;
    }

    public function format($item)
    {
        $mapping = array(
            '░' => MapBuilder::HERBE,
            '✿' => MapBuilder::FLEUR,
            '↟' => MapBuilder::ARBRE,
            '∼' => MapBuilder::EAU,
        );

        return (isset($mapping[$item]) ? $mapping[$item] : "X");
    }
}