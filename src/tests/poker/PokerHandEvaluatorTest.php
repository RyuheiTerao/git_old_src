<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use poker\PokerCard;
use poker\PokerHandEvaluator;
use poker\PokerTwoCardRule;
use poker\PokerThreeCardRule;



require_once(__DIR__ . '/../../lib/poker/PokerHandEvaluator.php');

class PokerHandEvaluatorTest extends TestCase
{
    public function testGetHand()
    {
        // カードが2枚の場合
        $handEvaluator = new PokerHandEvaluator(new PokerTwoCardRule());
        $this->assertSame(['role' => 'straight', 'roleRank' => 2, 'primary' => 13, 'secondary' => 12], $handEvaluator->getHand([new PokerCard('DA'), new PokerCard('SK')]));

        // カードが3枚の場合
        // $handEvaluator = new PokerHandEvaluator(new PokerThreeCardRule());
        // $this->assertSame('straight', $handEvaluator->getHand([new PokerCard('DA'), new PokerCard('S2'), new PokerCard('C3')]));
    }
}
