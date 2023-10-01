<?php

namespace Black_Jack;

require_once('Message.php');
require_once('Deck.php');
require_once('User.php');
require_once('Dealer.php');
require_once('CPU1.php');
require_once('CPU2.php');
require_once('Judge.php');
require_once('UserAction.php');

class Game
{
    private const DRAW = 1;
    private const STAND = 2;
    private const SURRENDER = 3;
    private const DOUBLE_DOWN = 4;
    private const SPRIT = 5;
    // private function __construct()
    // {
    // }
    public function Demo()
    {
        $message = new Message();
        $message->showStartMessage();

        $decks = [new Card('C', 1), new Card('C', 1), new Card('C', 10), new Card('C', 8), new Card('C', 10), new Card('C', 8), new Card('C', 10), new Card('C', 8),new Card('C', 10),new Card('C', 10),new Card('C', 10),new Card('C', 10),new Card('C', 10)];
        $deck = new Deck();
        $deck->changeDemoCards($decks);
        $user = new User();


        $players = $this->getPlayers($user);

        do {
            $message->showMoney($user);
            $user->answerBet();
            $message->showBetAnswer($user->betDollarCheck(), $user->getBet());
        } while (!($user->betDollarCheck()));

        foreach ($players as $player) {
            $player->drawCards($deck, 2);
        }

        foreach ($players as $player) {
            $message->showStartHandMessage($player);
        }


        $actionFlag = True;
        if ($user->getPoint() !== 21) {
            do {
                $message->showPoint($user);
                $message->questionUserAction($user);
                $userSelectAction = $user->answerAction();
                $actionResult = $user->userAction($userSelectAction);
                $actionFlag = True;

                if (($actionResult === self::DRAW) || ($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === True)) {
                    $message->showAddCard($user, $user->addCard($deck));
                } elseif (($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === False) || ($actionResult === self::SPRIT && $user->getSpritFlag() === False)) {
                    $message->showActionFaultReason();
                    $actionFlag = False;
                } elseif (($actionResult === self::SPRIT) && $user->getSpritFlag() === True) {
                    echo 'スプリットが選択されたため、手札を2分割し、ベットを2倍にします。' . PHP_EOL;
                }
            } while (($userSelectAction === self::DRAW || $userSelectAction === self::SPRIT || $actionFlag == False) && !($user->getBurstFlag()) && $user->getPoint() !== 21 && !($user->getSpritFlag()));
        }

        if (($actionResult === self::SPRIT) && $user->getSpritFlag() === True) {
            $this->selectSprit($user, $message, $deck, $players);
        }
        else{
            $playersAll = $players;

        array_shift($players);
        echo PHP_EOL;
        echo PHP_EOL;

        foreach ($players as $cpuPlayer) {
            $message->showCPUCard($cpuPlayer);
            $message->showPoint($cpuPlayer);
            $CPUAnswer = $cpuPlayer->answerAddCard();

            while ($CPUAnswer === 'Y') {
                $message->showAddCard($cpuPlayer, $cpuPlayer->addCard($deck));
                $message->showPoint($cpuPlayer);

                if (!($cpuPlayer->getBurstFlag())) {
                    $CPUAnswer = $cpuPlayer->answerAddCard();
                } else {
                    $CPUAnswer = 'N';
                }
            }

            echo PHP_EOL;
        }


        $judge = new Judge($playersAll);
        $judgeWinner = $judge->judgeWinner();
        $message->showWinner($judgeWinner);

        echo PHP_EOL;
        if ($judgeWinner[0] === 'User') {
            $user->setWinnerDollar();
        } else {
            $user->setLooserDollar();
        }

        $message->showResult($judgeWinner[0], $user);
        $message->showEndMessage();
    }
        }












    public function start()
    {
        $message = new Message();
        $message->showStartMessage();

        $deck = new Deck();

        $deck->shuffleDeck();

        $user = new User();


        $players = $this->getPlayers($user);

        do {
            $message->showMoney($user);
            $user->answerBet();
            $message->showBetAnswer($user->betDollarCheck(), $user->getBet());
        } while (!($user->betDollarCheck()));

        foreach ($players as $player) {
            $player->drawCards($deck, 2);
        }

        // $user->drawCards($deck, 2);
        // $dealer->drawCards($deck, 2);

        foreach ($players as $player) {
            $message->showStartHandMessage($player);
        }

        // $message->showStartHandMessage($user);
        // $message->showStartHandMessage($dealer);

        // $message->showPoint($players[self::USER]);
        // $message->questionAddCard($players[self::USER]);

        // $userAnswer = $players[self::USER]->answerAddCard();

        // while ($userAnswer === 'Y') {
        //     $message->showAddCard($players[self::USER], $players[self::USER]->addCard($deck));
        //     $message->showPoint($players[self::USER]);

        //     if (!($players[self::USER]->getBurstFlag())) {
        //         $message->questionAddCard($players[self::USER]);
        //         $userAnswer = $players[self::USER]->answerAddCard();
        //     } else {
        //         $userAnswer = 'N';
        //     }
        // }


        $actionFlag = True;
        if ($user->getPoint() !== 21) {
            do {
                $message->showPoint($user);
                $message->questionUserAction($user);
                $userSelectAction = $user->answerAction();
                $actionResult = $user->userAction($userSelectAction);
                $actionFlag = True;

                if (($actionResult === self::DRAW) || ($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === True)) {
                    $message->showAddCard($user, $user->addCard($deck));
                } elseif (($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === False) || ($actionResult === self::SPRIT && $user->getSpritFlag() === False)) {
                    $message->showActionFaultReason();
                    $actionFlag = False;
                } elseif (($actionResult === self::SPRIT) && $user->getSpritFlag() === True) {
                    echo 'スプリットが選択されたため、手札を2分割し、ベットを2倍にします。' . PHP_EOL;
                }
            } while (($userSelectAction === self::DRAW || $userSelectAction === self::SPRIT || $actionFlag == False) && !($user->getBurstFlag()) && $user->getPoint() !== 21);
        }

        if (($actionResult === self::SPRIT) && $user->getSpritFlag() === True) {
            $this->selectSprit($user, $message, $deck, $players);
        }

        $playersAll = $players;

        array_shift($players);
        echo PHP_EOL;
        echo PHP_EOL;

        foreach ($players as $cpuPlayer) {
            $message->showCPUCard($cpuPlayer);
            $message->showPoint($cpuPlayer);
            $CPUAnswer = $cpuPlayer->answerAddCard();

            while ($CPUAnswer === 'Y') {
                $message->showAddCard($cpuPlayer, $cpuPlayer->addCard($deck));
                $message->showPoint($cpuPlayer);

                if (!($cpuPlayer->getBurstFlag())) {
                    $CPUAnswer = $cpuPlayer->answerAddCard();
                } else {
                    $CPUAnswer = 'N';
                }
            }

            echo PHP_EOL;
        }


        $judge = new Judge($playersAll);
        $judgeWinner = $judge->judgeWinner();
        $message->showWinner($judgeWinner);

        echo PHP_EOL;
        if ($judgeWinner[0] === 'User') {
            $user->setWinnerDollar();
        } else {
            $user->setLooserDollar();
        }

        $message->showResult($judgeWinner[0], $user);
        $message->showEndMessage();
    }

    private function getPlayers(User $user): array
    {
        $dealer = new Dealer();
        $cpu1 = new CPU1();
        $cpu2 = new CPU2();
        return [$user, $dealer, $cpu1, $cpu2];
    }

    private function selectSprit(User $user, Message $message, Deck $deck, array $players): void
    {
        $spritCard = $user->doSprit();
        $user->setBet($user->getBet() / 2);
        $user->calcSprit();


        echo '1つ目の手札の操作を開始します。' . PHP_EOL;
        do {
            $message->showPoint($user);
            $message->questionUserAction($user);
            $userSelectAction = $user->answerAction();
            $actionResult = $user->userAction($userSelectAction);
            $actionFlag = True;

            if (($actionResult === self::DRAW) || ($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === True)) {
                $message->showAddCard($user, $user->addCard($deck));
            } elseif (($actionResult === self::DOUBLE_DOWN && $user->getDoubleDownFlag() === False)) {
                $message->showActionFaultReason();
                $actionFlag = False;
            }
        } while (($userSelectAction === self::DRAW || $userSelectAction === self::SPRIT || $actionFlag == False) && !($user->getBurstFlag()) && $user->getPoint() !== 21);

        echo '2つ目の手札の操作を開始します。' . PHP_EOL;
        $userSecond = new User();
        $userSecond->setSpritCard($spritCard);
        $userSecond->setBet($user->getBet());
        $userSecond->calcSprit();
        do {
            $message->showPoint($userSecond);
            $message->questionUserAction($userSecond);
            $userSecondSelectAction = $userSecond->answerAction();
            $actionResult = $userSecond->userAction($userSecondSelectAction);
            $actionFlag = True;

            if (($actionResult === self::DRAW) || ($actionResult === self::DOUBLE_DOWN && $userSecond->getDoubleDownFlag() === True)) {
                $message->showAddCard($userSecond, $userSecond->addCard($deck));
            } elseif (($actionResult === self::DOUBLE_DOWN && $userSecond->getDoubleDownFlag() === False) || ($actionResult === self::SPRIT && $userSecond->getSpritFlag() === False)) {
                $message->showActionFaultReason();
                $actionFlag = False;
            }
        } while (($userSecondSelectAction === self::DRAW || $userSecondSelectAction === self::SPRIT || $actionFlag == False) && !($userSecond->getBurstFlag()) && $userSecond->getPoint() !== 21);

        array_splice($players,1,0,[$userSecond]);

        $playersAll = $players;
        array_shift($players);
        array_shift($players);

        echo PHP_EOL;
        echo PHP_EOL;

        foreach ($players as $cpuPlayer) {
            $message->showCPUCard($cpuPlayer);
            $message->showPoint($cpuPlayer);
            $CPUAnswer = $cpuPlayer->answerAddCard();

            while ($CPUAnswer === 'Y') {
                $message->showAddCard($cpuPlayer, $cpuPlayer->addCard($deck));
                $message->showPoint($cpuPlayer);

                if (!($cpuPlayer->getBurstFlag())) {
                    $CPUAnswer = $cpuPlayer->answerAddCard();
                } else {
                    $CPUAnswer = 'N';
                }
            }

            echo PHP_EOL;
        }


        $judge = new JudgeSprit($playersAll);
        $judgeWinner = $judge->judgeWinner();
        $message->showSpritWinner($judgeWinner);

        echo PHP_EOL;
        if ($judgeWinner[1] === 'User') {
            if ($judgeWinner[2] === True) {
                $user->setBet($user->getBet() * 2);
                $user->setWinnerDollar();
            }
            $user->setWinnerDollar();
        } else {
            $user->setLooserDollar();
        }

        $message->showResult($judgeWinner[1], $user);
        $message->showEndMessage();
    }
}

$game = new Game();
// $game->start();

$game->Demo();
