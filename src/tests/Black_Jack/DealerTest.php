<?php

namespace Black_Jack\Tests;
use Black_Jack\Deck;
use Black_Jack\Card;
use Black_Jack\Dealer;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Deck.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Card.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Dealer.php');

class Black_JackDealerTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDrawCards()
    {
        $Deck = new Deck();
        $Dealer = new Dealer();
        $result = $Dealer->drawCards($Deck, 2);
        $this->assertSame(2, count($result));
    }

    // @phpstan-ignore-next-line
    public function testAddCard()
    {
        $Deck = new Deck();
        $Dealer = new Dealer();
        $result = $Dealer->addCard($Deck);
        $this->assertSame(1, count($result));
    }

    // @phpstan-ignore-next-line
    public function testGetHands()
    {
        $Deck = new Deck();
        $Dealer = new Dealer();
        $Dealer->drawCards($Deck, 2);
        $Dealer->addCard($Deck);

        $result = $Dealer->getHands();

        $this->assertSame(3, count($result));
    }

    // @phpstan-ignore-next-line
    public function testGetPoint()
    {
        $Deck = new Deck();
        $Dealer = new Dealer();
        $Dealer->drawCards($Deck, 2);
        $Dealer->addCard($Deck);

        $hands = $Dealer->getHands();


        $result = $Dealer->getPoint();

        $this->assertSame(16, $result);
    }

    // @phpstan-ignore-next-line
    public function testGetPlayerInformation()
    {
        $Dealer = new Dealer;
        $result = $Dealer->getPlayerInformation();
        $this->assertSame('Dealer', $result);

    }

    public function testAnswerAddCard()
    {
        $Dealer = new Dealer;
        $Deck = new Deck();
        $Dealer->drawCards($Deck,5);
        $input1 = $Dealer->answerAddCard();
        $Dealer->addCard($Deck);
        $input2 = $Dealer->answerAddCard($Deck);

        $this->assertSame('Y',$input1);
        $this->assertSame('N',$input2);

    }

}
