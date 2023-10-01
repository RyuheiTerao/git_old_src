<?php

namespace Black_Jack\Tests;

use Black_Jack\Judge;
use Black_Jack\User;
use Black_Jack\Dealer;
use Black_Jack\Deck;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Judge.php');
require_once(__DIR__ . '/../../lib/Black_Jack/User.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Dealer.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Deck.php');

class Black_JackJudgeTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testJudgeWinner()
    {
        $User = new User();
        $Dealer = new Dealer();
        $Deck = new Deck();
        $User->drawCards($Deck,2);      //1,2
        $Dealer->drawCards($Deck,2);    //3,4
        $User->drawCards($Deck,2);      //5,6

        $judge = new Judge([$User,$Dealer]);
        $result = $judge->judgeWinner();
        $playerInfo = [
            'User' => 14,
            'Dealer' => 7,
            'CPU1' => 0,
            'CPU2' => 0,
        ];
        $this->assertSame('User', $result[0]);
        $this->assertSame($playerInfo,$result[1]);
    }

}
