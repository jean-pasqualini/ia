<?php
/**
 * Created by PhpStorm.
 * User: darkilliant
 * Date: 29/12/15
 * Time: 17:11
 */

namespace Map\Player;

use Map\Player\Chat\Estomac;

interface PlayerHasEstomac {

    /**
     * @return Estomac
     */
    public function getEstomac();
}