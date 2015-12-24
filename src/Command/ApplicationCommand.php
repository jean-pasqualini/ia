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
use Map\World\World;
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

        $map = new MapBuilder((new RandomMapProvider($line, $colonne))->getMap());

        $world = new World($map, array(
            $this->addChat(5, 5),
            $this->addChat(10, 10)
        ));

        try {
            $this->render($mapRender, $world);
        }
        catch(\Exception $e)
        {
            $symfonyStyle->error($e->getMessage());

            return;
        }
    }

    protected function addChat($x, $y)
    {
        $chat = new Chat();

        $chat->getPosition()->setDirection(new Direction(1, 0));

        $chat->getPosition()->setX($x);

        $chat->getPosition()->setY($y);

        return $chat;
    }

    public function render(ConsoleMapRender $mapRender, World $world)
    {
        $world->update();

        $players = $world->getPlayerCollection();

        foreach($players as $player)
        {
            $world->getMap()->setItem($player->getPosition(), "P");
        }

        $mapRender->render($world->getMap()->getMap());

        usleep(200);

        $mapRender->clear($world->getMap()->getMap());

        $this->render($mapRender, $world);
    }
}