<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 28/12/15
 * Time: 13:12
 */

namespace Map\Render\Curse;


use CurseFramework\Listbox;

class Statictic extends Listbox {

    public function update()
    {
        $this->setItems(array(
            array("title" => "memory : ".$this->convert(memory_get_usage()), "bold" => false),
        ));

        $this->setChanged(true);
    }

    protected function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}