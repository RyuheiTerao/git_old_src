<?php

namespace Black_Jack;

require_once('Card.php');

class Deck
{
    private array $cards;

    public function __construct()
    {
        foreach (['C', 'H', 'S', 'D'] as $suit) {
            foreach (range(1, 13) as $number)
                $this->cards[] = new Card($suit, $number);
        }
    }

    public function drawCards(int $drawNum): array
    {
        $drawCards = [];
        for ($i = 0; $i < $drawNum; $i++) {
            $drawCards[] = array_shift($this->cards);
        }

        return $drawCards;
    }

    public function shuffleDeck(): void
    {
        shuffle($this->cards);
    }

    public function changeDemoCards(array $cards):void
    {
        $this->cards = $cards;
    }
}
