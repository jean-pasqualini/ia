<?php
/**
 * Created by PhpStorm.
 * User: Freelance
 * Date: 24/12/2015
 * Time: 14:01
 */

namespace IA;


use Map\World\World;

interface IAInterface
{
    public function update(World $world);
}