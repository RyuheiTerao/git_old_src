<?php

namespace Black_Jack;

require_once('Player.php');
require_once('PlayerInterface.php');

class Dealer extends Player implements PlayerInterface
{
    private string $playerInformation = 'Dealer';

    public function getPlayerInformation(): string
    {
        return $this->playerInformation;
    }

    public function answerAddCard(): string
    {
        $answer = 'Y';
        if ($this->sumPoint > 17) {
            $answer = 'N';
        };
        return $answer;
    }
}
