<?php

namespace OopPoker;

require_once('Card.php');

class Deck
{
    private array $cards;

    public function __construct()
    {
        foreach(['C','H','S','D'] as $suit){
            foreach(range(1,13) as $number){
                $this->cards[] = new Card($suit,$number);
            }
        }
    }

    public function drawCards(int $drawNum)
    {
        return array_slice($this->cards, 0,$drawNum);
    }

    public function getDeck()
    {
        return $this->cards;
    }
}
