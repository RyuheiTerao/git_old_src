<?php

namespace OopPoker\Tests;
use OopPoker\Card;
use OopPoker\RuleC;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/RuleC.php');

class RuleCTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetHand()
    {
        $rule = new RuleC();
        $cards = [new Card('H',10),new Card('C',10)];
        $this->assertSame('straight', $rule->getHand($cards));

    }
}
