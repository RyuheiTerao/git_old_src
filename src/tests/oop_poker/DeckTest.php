<?php

namespace OopPoker\Tests;
use OopPoker\Deck;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Deck.php');

class DeckTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDrawCards()
    {
        $deck = new Deck();
        $cards = $deck->drawCards(2);
        $this->assertSame(2, count($cards));
    }
}
