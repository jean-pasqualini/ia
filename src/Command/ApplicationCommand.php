<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 10:24
 */

namespace Command;


use Map\Builder\MapBuilder;
use Map\Location\Direction;
use Map\Provider\FileMapProvider;
use Map\Provider\RandomMapProvider;
use Map\Render\ConsoleMapRender;
use Map\Player\Chat;
use Map\Player\PlayerInterface;
use Map\Render\MapRenderInterface;
use Map\Render\NCurseRender;
use Map\World\World;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApplicationCommand extends Command
{
    public function configure()
    {
        $this->setName("application");
        $this->addOption("curse", null, InputOption::VALUE_NONE, "active curse");
        $this->addOption("size", null, InputOption::VALUE_REQUIRED, "taille", exec('tput lines')."x".exec('tput cols'));
        $this->addOption("load-dump", null, InputOption::VALUE_REQUIRED, "memory load dump");
        $this->addOption("map", null, InputOption::VALUE_REQUIRED, "file");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        mb_internal_encoding('UTF-8');

        try {

            list($line, $colonne) = explode("x", $input->getOption("size"));


            $symfonyStyle = new SymfonyStyle($input, $output);
            $symfonyStyle->title("IA");

            $mapRender = (!$input->getOption("curse")) ? new ConsoleMapRender($output, true) : new NCurseRender($line, $colonne);

            if(!$input->getOption("load-dump"))
            {
                $sizeMap = $mapRender->getSize();

                $mapProvider = ($input->getOption("map")) ? new FileMapProvider($input->getOption("map")) : new RandomMapProvider($sizeMap["y"], $sizeMap["x"]);

                $map = new MapBuilder($mapProvider->getMap());

                $world = new World($map, array(
                    $this->addChat(5, 5),
                    $this->addChat(10, 10)
                ));
            }
            else
            {
                $file = $input->getOption("load-dump");

                if(!file_exists($file))
                {
                    if(extension_loaded("ncurses") && $mapRender instanceof NCurseRender) ncurses_end();

                    $symfonyStyle->error("le fichier $file n'existe pas");

                    return;
                }

                $world = unserialize(file_get_contents($file))->getFlashMemory()->all()[0]->getData();
            }

            while(1) { $this->render($mapRender, $world); }
        }
        catch(\Exception $e)
        {
            if(extension_loaded("ncurses") && $mapRender instanceof NCurseRender) ncurses_end();

            $symfonyStyle->error($e->getMessage());

            return;
        }
    }

    protected function addChat($x, $y)
    {
        $chat = new Chat();
       // $chat->getPosition()->setDirection(new Direction(1, 0));

        $chat->getPosition()->setX($x);

        $chat->getPosition()->setY($y);

        return $chat;
    }

    public function render(MapRenderInterface $mapRender, World $world)
    {
        $world->update();

        if($world->getInputController()->getKey() == "x")
        {
            $world->getMemoryManager()->persist();

            return;
        }

        $players = $world->getPlayerCollection();

        foreach($players as $player)
        {
            $world->getMap()->setItem($player->getPosition(), "P");
        }

        $mapRender->render($world->getMap()->getMap());

        //usleep(200);

        $mapRender->clear($world->getMap()->getMap());
    }
}
