<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use poker\PokerCard;
use poker\PokerTwoCardRule;


require_once(__DIR__ . '/../../lib/poker/PokerTwoCardRule.php');

class PokerTwoCardRuleTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new PokerTwoCardRule();
        $this->assertSame(['role' => 'high card','roleRank' => 0,'primary' => 6,'secondary' =>4], $rule->getHand([new PokerCard('H5'), new PokerCard('C7')]));
        $this->assertSame(['role' => 'pair','roleRank' => 1,'primary' => 9,'secondary' =>9], $rule->getHand([new PokerCard('H10'), new PokerCard('C10')]));
        $this->assertSame(['role' => 'straight','roleRank' => 2,'primary' => 1,'secondary' =>0],$rule->getHand([new PokerCard('DA'), new PokerCard('S2')]));
        $this->assertSame(['role' => 'straight','roleRank' => 2,'primary' => 13,'secondary' =>12], $rule->getHand([new PokerCard('DA'), new PokerCard('SK')]));
    }
}
