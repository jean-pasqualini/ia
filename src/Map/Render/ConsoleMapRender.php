<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:35
 */

namespace Map\Render;

use Command\NCursesOutput;
use Map\Builder\MapBuilder;
use Map\Map;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleMapRender
{
    protected $standardOutput;

    protected $output;

    protected $columns;

    public function __construct(OutputInterface $output, $buffer = false, $ncurse = false)
    {
        if(extension_loaded("ncurses") && $ncurse)
        {
            $output = new NCursesOutput();
        }

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

        if($this->output instanceof NCursesOutput)
        {
            $this->output->flush();
        }
    }

    public function clear($map)
    {
        sleep(1);

        if($this->output instanceof NCursesOutput) $this->output->clear();
        $this->output->write(str_repeat("\x08", count($map) * $this->columns));

        $this->flushOutput();
    }

    public function format($item)
    {
        $mapping = array(
            MapBuilder::HERBE => '<fg=green;bg=green>✿</>',
            //MapBuilder::HERBE => '<fg=red;bg=green>✿</>'
            MapBuilder::ARBRE => '<fg=black;bg=green>↟</>',
            MapBuilder::EAU => '<fg=white;bg=cyan>∼</>',
            "P" => '<fg=white;bg=green>☺</>',
        );

        return (isset($mapping[$item]) ? $mapping[$item] : $item);
    }

}