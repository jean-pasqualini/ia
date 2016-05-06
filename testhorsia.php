<?php

function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

function moi()
{
echo 'moi'.PHP_EOL;

echo convert(memory_get_usage()).PHP_EOL;

//moi();
}

while(1) { moi(); }
