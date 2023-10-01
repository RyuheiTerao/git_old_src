<?php

namespace Black_Jack\Tests;
use Black_Jack\Deck;
use Black_Jack\Card;
use Black_Jack\User;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Deck.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Card.php');
require_once(__DIR__ . '/../../lib/Black_Jack/User.php');

class Black_JackUserTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDrawCards()
    {
        $Deck = new Deck();
        $User = new User();
        $result = $User->drawCards($Deck, 2);
        $this->assertSame(2, count($result));
    }

    // @phpstan-ignore-next-line
    public function testAddCard()
    {
        $Deck = new Deck();
        $User = new User();
        $result = $User->addCard($Deck);
        $this->assertSame(1, count($result));
    }

    // @phpstan-ignore-next-line
    public function testGetHands()
    {
        $Deck = new Deck();
        $User = new User();
        $User->drawCards($Deck, 2);
        $User->addCard($Deck);

        $result = $User->getHands();

        $this->assertSame(3, count($result));
    }

    // @phpstan-ignore-next-line
    public function testGetPoint()
    {
        $Deck = new Deck();
        $User = new User();
        $User->drawCards($Deck, 2);
        $User->addCard($Deck);

        $hands = $User->getHands();


        $result = $User->getPoint();

        $this->assertSame(16, $result);
    }

    // @phpstan-ignore-next-line
    public function testGetPlayerInformation()
    {
        $User = new User;
        $result = $User->getPlayerInformation();
        $this->assertSame('User', $result);
    }

    // public function testAnswerAddCard()
    // {
    //     $User = new User;
    //     $input = $User->answerAddCard();
    //     $this->assertSame('input',$input);
    // }
}
