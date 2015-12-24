<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 12:03
 */

namespace Map\Render;


use Map\Builder\MapBuilder;

class WebMapRender
{
    public function render($map)
    {
        $output = "";

        $output .= <<<EOF
        <head>
            <meta http-equiv="refresh" content="0">
        </head>
EOF;


        $output .= "<table>";

        foreach($map as $line)
        {
            $output .= "<tr>";

            foreach($line as $item)
            {
                $output.= "<td>".$this->format($item)."</td>";
            }

            $output .= "<tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    public function format($item)
    {
        $mapping = array(
            MapBuilder::HERBE => '<div style="background: green; color: green;">H</div>',
            MapBuilder::ARBRE => '<div style="background: black; color: black;">A</div>',
            MapBuilder::EAU => '<div style="background: cyan; color: cyan;">E</div>',
            "P" => '<div style="background: magenta; color: magenta;">P</div>',
        );

        return (isset($mapping[$item]) ? $mapping[$item] : $item);
    }
}