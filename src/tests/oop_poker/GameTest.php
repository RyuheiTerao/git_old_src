<?php

namespace OopPoker\Tests;
use OopPoker\Game;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/Game.php');

class GameTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testStart()
    {
        $game = new Game('田中','松本', 2,'A');
        $result = $game->start();
        $this->assertSame(1, $result);
    }
}
