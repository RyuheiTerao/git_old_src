<?php

namespace Black_Jack\Tests;
use Black_Jack\Deck;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Deck.php');

class Black_JackDeckTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDrawCards()
    {
        $Deck = new Deck();
        $result = $Deck->drawCards(10);
        $this->assertSame(count($result), 10);
    }
}
