<?php

namespace Black_Jack;

require_once('Dealer.php');
require_once('PlayerInterface.php');

class CPU2 extends Dealer
{
    private string $playerInformation = 'CPU2';

    public function getPlayerInformation(): string
    {
        return $this->playerInformation;
    }
}
