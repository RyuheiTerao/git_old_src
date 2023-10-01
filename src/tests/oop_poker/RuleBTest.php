<?php

namespace OopPoker\Tests;
use OopPoker\Card;
use OopPoker\RuleB;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/RuleB.php');

class RuleBTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetHand()
    {
        $rule = new RuleB();
        $cards = [new Card('H',10),new Card('C',10)];
        $this->assertSame('high card', $rule->getHand($cards));

    }
}
