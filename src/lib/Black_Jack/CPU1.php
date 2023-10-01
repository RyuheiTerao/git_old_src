<?php

namespace Black_Jack;

require_once('Dealer.php');
require_once('PlayerInterface.php');

class CPU1 extends Dealer
{
    private string $playerInformation = 'CPU1';

    public function getPlayerInformation(): string
    {
        return $this->playerInformation;
    }
}
