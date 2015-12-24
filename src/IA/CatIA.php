<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 13:59
 */

namespace IA;


use Map\Player\Chat;
use Map\World\World;

class CatIA implements IAInterface
{
    protected $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function update(World $world)
    {
        $this->chat->move();
    }
}