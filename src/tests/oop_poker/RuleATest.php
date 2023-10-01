<?php

namespace OopPoker\Tests;
use OopPoker\Card;
use OopPoker\RuleA;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/RuleA.php');

class RuleATest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetHand()
    {
        $rule = new RuleA();
        $cards = [new Card('H',10),new Card('C',10)];
        $this->assertSame('pair', $rule->getHand($cards));

    }
}
