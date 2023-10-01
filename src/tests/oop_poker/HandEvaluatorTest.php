<?php

namespace OopPoker\Tests;
use OopPoker\Card;
use OopPoker\HandEvaluator;
use OopPoker\RuleA;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/HandEvaluator.php');
require_once(__DIR__ . '/../../lib/oop_poker/RuleA.php');
require_once(__DIR__ . '/../../lib/oop_poker/Card.php');

class HandEvaluatorTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testGetHand()
    {
        $handEvaluator = new HandEvaluator(new RuleA());
        $cards = [new Card('H',10),new Card('C',10)];
        $this->assertSame('pair', $handEvaluator->getHand($cards));
    }

    public function testGetWinner()
    {
        $this->assertSame(1, HandEvaluator::getWinner('pair','high card'));
    }
}
