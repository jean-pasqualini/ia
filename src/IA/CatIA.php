<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 13:59
 */

namespace IA;


use IA\Objectif\Manger;
use Map\Player\Chat;
use Map\Player\ChatEvent;
use Map\World\World;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CatIA implements IAInterface
{
    protected $chat;

    protected $objectifs = array();

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;

        $this->chat->getEventDispatcher()->addListener(ChatEvent::HUNGRY, array($this, "onEstomacHungry"));
        $this->chat->getEventDispatcher()->addListener(ChatEvent::FULL, array($this, "onEstomacFull"));
    }

    public function onEstomacHungry()
    {
        if(!empty($this->objectifs)) return;

        $this->objectifs[] = new Manger($this->chat);
    }

    public function onEstomacFull()
    {
        $this->objectifs = array();
    }

    public function getObjectifs()
    {
        return $this->objectifs;
    }

    public function update(World $world)
    {
        $this->chat->move();

        foreach($this->objectifs as $objectif)
        {
            $objectif->update($world);
        }
    }
}