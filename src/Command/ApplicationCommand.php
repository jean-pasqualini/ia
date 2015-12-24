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
use Map\Provider\RandomMapProvider;
use Map\Render\ConsoleMapRender;
use Map\Player\Chat;
use Map\Player\PlayerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ApplicationCommand extends Command
{
    public function configure()
    {
        $this->setName("application");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $line = 30; //exec('tput lines');
        $colonne = 40; //exec('tput cols');

        //$line = exec('tput lines');
        //$colonne = exec('tput cols');

        $symfonyStyle = new SymfonyStyle($input, $output);

        $symfonyStyle->title("IA");

        $mapRender = new ConsoleMapRender($output);

        $chat = new Chat();

        $chat->getPosition()->setDirection(new Direction(1, 0));

        $map = new MapBuilder((new RandomMapProvider($line, $colonne))->getMap());

        $this->render($mapRender, $map, $chat);
    }

    public function render(ConsoleMapRender $mapRender, MapBuilder $map, PlayerInterface $player)
    {
        $player->move();

        $map->setItem($player->getPosition(), "P");

        $mapRender->render($map->getMap());

        usleep(200);

        $mapRender->clear($map->getMap());

        $this->render($mapRender, $map, $player);
    }
}