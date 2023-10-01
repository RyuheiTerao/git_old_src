<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use poker\PokerCard;
use poker\PokerThreeCardRule;


require_once(__DIR__ . '/../../lib/poker/PokerThreeCardRule.php');

class PokerThreeCardRuleTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new PokerThreeCardRule();
        $this->assertSame(['role' => 'high card', 'roleRank' => 0, 'primary' => 8, 'secondary' => 6, 'tertiary' => 4], $rule->getHand([new PokerCard('H5'), new PokerCard('C7'), new PokerCard('C9')]));
        $this->assertSame(['role' => 'high card', 'roleRank' => 0, 'primary' => 13, 'secondary' => 12, 'tertiary' => 1], $rule->getHand([new PokerCard('HK'), new PokerCard('CA'), new PokerCard('C2')]));
        $this->assertSame(['role' => 'pair', 'roleRank' => 1, 'primary' => 10, 'secondary' => 9, 'tertiary' => 9], $rule->getHand([new PokerCard('H10'), new PokerCard('C10'), new PokerCard('CJ')]));
        $this->assertSame(['role' => 'straight', 'roleRank' => 2, 'primary' => 2, 'secondary' => 1, 'tertiary' => 0], $rule->getHand([new PokerCard('DA'), new PokerCard('S2'), new PokerCard('C3')]));
        $this->assertSame(['role' => 'straight', 'roleRank' => 2, 'primary' => 13, 'secondary' => 12, 'tertiary' => 11], $rule->getHand([new PokerCard('DA'), new PokerCard('SQ'), new PokerCard('SK')]));
        $this->assertSame(['role' => 'three card', 'roleRank' => 3, 'primary' => 13, 'secondary' => 13, 'tertiary' => 13], $rule->getHand([new PokerCard('DA'), new PokerCard('SA'), new PokerCard('DA')]));
    }
}
