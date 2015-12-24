<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:35
 */

namespace Map\Render;

use Map\Builder\MapBuilder;
use Map\Map;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleMapRender
{
    protected $standardOutput;

    protected $output;

    protected $columns;

    public function __construct(OutputInterface $output, $buffer = false)
    {
        $this->columns = exec('tput cols');

        $this->standardOutput = ($buffer) ? $output : null;

        $this->output = ($buffer) ? new BufferedOutput() : $output;
    }

    public function render($map)
    {
        foreach($map as $line)
        {
            foreach($line as $item)
            {
                $this->output->write($this->format($item));
            }

            $this->output->writeln("");
        }

        $this->flushOutput();
    }

    protected function flushOutput()
    {
        if($this->standardOutput !== null) $this->standardOutput->write($this->output->fetch());
    }

    public function clear($map)
    {
        $this->output->write(str_repeat("\x08", count($map) * $this->columns));

        $this->flushOutput();
    }

    public function format($item)
    {
        $mapping = array(
            MapBuilder::HERBE => '<fg=green;bg=green>H</>',
            MapBuilder::ARBRE => '<fg=black;bg=black>A</>',
            MapBuilder::EAU => '<fg=cyan;bg=cyan>E</>',
            "P" => '<fg=magenta;bg=magenta>P</>',
        );

        return (isset($mapping[$item]) ? $mapping[$item] : $item);
    }

}