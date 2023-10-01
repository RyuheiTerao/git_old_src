<?php

namespace Poker\Tests;

use PHPUnit\Framework\TestCase;
use poker\PokerGame;

require_once(__DIR__ . '/../../lib/poker/PokerGame.php');

class PokerGameTest extends TestCase
{
    public function testStart()
    {
        // カードが2枚の場合
        $game1 = new PokerGame(['CA', 'DA'], ['C9', 'H10']);
        $this->assertSame(['pair', 'straight', 2], $game1->start());

        //カードが3枚の場合
        $game2 = new PokerGame(['C2', 'D2', 'S2'], ['C10', 'H9', 'DJ']);
        $this->assertSame(['three card', 'straight', 1], $game2->start());
    }
}
