<?php

namespace Black_Jack\Tests;

use Black_Jack\Message;
use Black_Jack\User;
use Black_Jack\Dealer;
use Black_Jack\Deck;
use Black_Jack\Judge;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/Black_Jack/Player.php');
require_once(__DIR__ . '/../../lib/Black_Jack/User.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Dealer.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Deck.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Message.php');
require_once(__DIR__ . '/../../lib/Black_Jack/Judge.php');

class Black_JackMessageTest extends TestCase
{

    // @phpstan-ignore-next-line
    public function testShowStartMessage()
    {
        $message = new Message();

        $output = <<<EOD
        ブラックジャックを開始します

        EOD;
        $this->expectOutputString($output);

        $message->showStartMessage();
    }

    // @phpstan-ignore-next-line
    public function testShowUserFirstHands()
    {
        $message = new Message();
        $Deck = new Deck();
        $User = new User();
        $User->drawCards($Deck, 2);
        $User->addCard($Deck);

        $outputUser = <<<EOD
        あなたの引いたカードはクラブのAです。
        あなたの引いたカードはクラブの2です。

        EOD;
        $this->expectOutputString($outputUser);

        $message->showStartHandMessage($User);
    }

    // @phpstan-ignore-next-line
    public function testShowDealerFirstHands()
    {
        $message = new Message();
        $Deck = new Deck();
        $Dealer = new Dealer();
        $Dealer->drawCards($Deck, 2);
        $Dealer->addCard($Deck);

        $outputDealer = <<<EOD
        ディーラーの引いたカードはクラブのAです。
        ディーラーの引いた2枚目のカードはわかりません。

        EOD;
        $this->expectOutputString($outputDealer);

        $message->showStartHandMessage($Dealer);
    }

    // @phpstan-ignore-next-line
    public function testShowPointUser()
    {
        $message = new Message();
        $Deck = new Deck();
        $User = new User();
        $User->drawCards($Deck, 2);
        $User->addCard($Deck);

        $outputUser = <<<EOD
        あなたの現在の得点は16です。
        EOD;
        $this->expectOutputString($outputUser);

        $message->showPoint($User);
    }

    // @phpstan-ignore-next-line
    public function testShowPointDealer()
    {
        $message = new Message();
        $Deck = new Deck();
        $Dealer = new Dealer();
        $Dealer->drawCards($Deck, 2);
        $Dealer->addCard($Deck);

        $outputUser = <<<EOD
        ディーラーの現在の得点は16です。
        EOD;
        $this->expectOutputString($outputUser);

        $message->showPoint($Dealer);
    }

    // @phpstan-ignore-next-line
    public function testShowAddCardUser()
    {
        $message = new Message();
        $Deck = new Deck();
        $User = new User();
        $card = $User->addCard($Deck);

        $outputUser = <<<EOD
            あなたの引いたカードはクラブのAでした。

            EOD;
        $this->expectOutputString($outputUser);

        $message->showAddCard($User, $card);
    }

    // @phpstan-ignore-next-line
    public function testShowAddCardDealer()
    {
        $message = new Message();
        $Deck = new Deck();
        $Dealer = new Dealer();
        $card = $Dealer->addCard($Deck);

        $outputUser = <<<EOD
        ディーラーの引いたカードはクラブのAでした。

        EOD;
        $this->expectOutputString($outputUser);

        $message->showAddCard($Dealer, $card);
    }

    public function testShowDealerCard()
    {
        $message = new Message();
        $Deck = new Deck();
        $Dealer = new Dealer();
        $Dealer->drawCards($Deck,2);

        $outputUser = <<<EOD
        ディーラーの引いた2枚目のカードはクラブの2でした。

        EOD;
        $this->expectOutputString($outputUser);

        $message->showCPUCard($Dealer);
    }

    public function testUserShowWinner()
    {
        $message = new Message();
        $User = new User();
        $Dealer = new Dealer();
        $DeckUser = new Deck();
        $DeckDealer = new Deck();

        $User->drawCards($DeckUser, 6);
        $Dealer->drawCards($DeckDealer, 7);

        $judge = new Judge([$User, $Dealer]);

        $outputUserWin = <<<EOD
        あなたの得点は21です。
        ディーラーの得点は28です。
        あなたの勝ちです!

        EOD;

        $this->expectOutputString($outputUserWin);
        $message->showWinner($judge->judgeWinner());
    }

    public function testDealerShowWinner()
    {
        $message = new Message();
        $User = new User();
        $Dealer = new Dealer();
        $DeckUser = new Deck();
        $DeckDealer = new Deck();

        $User->drawCards($DeckUser, 7);
        $Dealer->drawCards($DeckDealer, 6);

        $judge = new Judge([$User, $Dealer]);

        $message->showWinner($judge->judgeWinner());
        $outputDealerWin = <<<EOD
        あなたの得点は28です。
        ディーラーの得点は21です。
        ディーラーの勝ちです!

        EOD;

        $this->expectOutputString($outputDealerWin);
    }

    // @phpstan-ignore-next-line
    public function testShowEndMessage()
    {
        $message = new Message();

        $output = <<<EOD
            ブラックジャックを終了します

            EOD;
        $this->expectOutputString($output);

        $message->showEndMessage();
    }

    public function testQuestionUserAction()
    {
        $message = new Message();
        $user = new User();
        $deck = new Deck();

        $user->drawCards($deck,2);
        $message->questionUserAction($user);

        $output = <<<EOD
        次の行動を選択してください。(整数で入力)
        1.カードを引く
        2.スタンド
        3.ダブルダウン
        4.サレンダー

        EOD;

        $this->expectOutputString($output);

    }
    public function testQuestionUserActionSprit()
    {
        $message = new Message();
        $user = new User();
        $deck = new Deck();

        $user->drawCards($deck,1);

        $deck->drawCards(12);

        $user->drawCards($deck,1);
        $message->questionUserAction($user);

        $output = <<<EOD
        次の行動を選択してください。(整数で入力)
        1.カードを引く
        2.スタンド
        3.ダブルダウン
        4.サレンダー
        5.スプリット

        EOD;

        $this->expectOutputString($output);

    }

}
