<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 28/12/15
 * Time: 13:03
 */

namespace InputController;


use Map\Location\Direction;
use Map\Player\PlayerInterface;
use Psr\Log\LoggerInterface;

class KeyboardInputController {

    public $direction;

    public $key;

    /** @var PlayerInterface */
    private $player;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(PlayerInterface $player, LoggerInterface $logger)
    {
        $this->player = $player;
        $this->direction = new Direction(0, 0);
        $this->logger = $logger;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function isKey($key)
    {
        $is = $this->key == $key;

        if ($is) {
            $this->key = null;
        }

        return $is;
    }

    public function update()
    {
        $stdin = fopen('php://stdin', 'r');
        stream_set_blocking($stdin, false);
        stream_set_timeout($stdin, 0, 200);

        $key = fgets($stdin, 2);

        // No input right now
        if (!empty($key)) {

            $this->key = $key;

            switch($key)
            {
                case "q": //left
                    $this->direction = new Direction(-1, 0);
                    break;
                case "z": //upa
                    $this->direction = new Direction(0, -1);
                    break;
                case "d": //right
                    $this->direction = new Direction(1, 0);
                    break;
                case "s": //down
                    $this->direction = new Direction(0, 1);
                    break;
                default:
                    $this->direction = new Direction(0, 0);
                    break;
            }

            $this->player->getPosition()->setDirection($this->direction);
            $this->player->move();

            $this->logger->info(sprintf(
                'KEYPRESS %s',
                $key
            ));
        }

    }
}