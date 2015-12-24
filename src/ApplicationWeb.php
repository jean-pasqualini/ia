<?php

use Map\Render\WebMapRender;
use Map\Player\Chat;
use Map\Location\Direction;
use Map\Provider\RandomMapProvider;
use Map\Builder\MapBuilder;

require __DIR__."/../vendor/autoload.php";

session_start();

$line = 30; //exec('tput lines');
$colonne = 40; //exec('tput cols');

//$line = exec('tput lines');
//$colonne = exec('tput cols');

$mapRender = new WebMapRender();

if(!isset($_SESSION["chat"]))
{
    $chat = new Chat();

    $chat->getPosition()->setDirection(new Direction(1, 0));
}
else
{
    $chat = unserialize($_SESSION["chat"]);
}

if(!isset($_SESSION["map"]))
{
    $map = new MapBuilder((new RandomMapProvider($line, $colonne))->getMap());
}
else
{
    $map = unserialize($_SESSION["map"]);
}

$chat->move();

$map->setItem($chat->getPosition(), "P");

$mapRender->render($map->getMap());

$_SESSION["chat"] = serialize($chat);
$_SESSION["map"] = serialize($map);