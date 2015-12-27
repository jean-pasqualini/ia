<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 12:03
 */

namespace Map\Render;


use Map\Builder\MapBuilder;

class WebMapRender implements MapRenderInterface
{
    public $updateTime = 0;

    public function render($map)
    {
        $output = "";

        $output .= <<<EOF
        <head>
            <meta http-equiv="refresh" content="0">
        </head>

        <style type="text/css">
            .block
            {
                width: 30px;
                height: 30px;
                text-align: center;
                vertical-align: middle;
                font-size: 25px;
            }

            html, body
            {
                margin: 0px;
                background: black;
            }

            table {
                border-collapse:collapse;
                width: 50%;
                margin: auto;
            }
        </style>
EOF;

        $output = str_replace('"0"', '"'.$this->updateTime.'"', $output);


        $output .= "<table>";

        foreach($map as $line)
        {
            $output .= "<tr style='padding: 0px;'>";

            foreach($line as $item)
            {
                $output.= "<td style='padding: 0px; border-spacing: 0px;'>".$this->format($item)."</td>";
            }

            $output .= "</tr>";
        }

        $output .= "</table>";

        echo $output;
    }

    public function format($item)
    {
        $mapping = array(
            MapBuilder::HERBE => '<div style="background: lightgreen; color: lightgreen;" class="block">&nbsp;</div>',
            MapBuilder::ARBRE => '<div style="background: lightgreen; color: black;" class="block">↟</div>',
            MapBuilder::FLEUR => '<div style="background: lightgreen; color: red;" class="block">✿</div>',
            MapBuilder::EAU => '<div style="background: cyan; color: white;" class="block">∼</div>',
            "P" => '<div style="background: magenta; green: white;" class="block">☺</div>',
        );

        return (isset($mapping[$item]) ? $mapping[$item] : $item);
    }
}