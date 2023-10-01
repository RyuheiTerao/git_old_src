<?php

namespace Black_Jack\Tests;
use Black_Jack\Card;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Card.php');

class Black_JackCardTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetSuit()
    {
        $Card = new Card('C',5);
        $suit = $Card->getSuit();
        $this->assertSame('C', $suit);
    }

    // @phpstan-ignore-next-line
    public function testGetNumber()
    {
        $Card = new Card('C',5);
        $num = $Card->getNumber();
        $this->assertSame(5, $num);
    }
}
