<?php

namespace OopPoker\Tests;
use OopPoker\Card;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Card.php');

class CardTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetSuit()
    {
        $card = new Card('C', 5);
        $this->assertSame('C', $card->getSuit());
    }

    public function testGetNumber()
    {
        $card = new Card('C', 5);
        $this->assertSame(5, $card->getNumber());
    }
}
