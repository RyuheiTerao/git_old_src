<?php

namespace Black_Jack;

require_once('Player.php');
require_once('PlayerInterface.php');
require_once('UserAction.php');

class User extends Player implements PlayerInterface, UserAction
{
    private string $playerInformation = 'User';
    private bool $standFlag = False;
    private bool $doubleDownFlag = False;
    private bool $surrenderFlag = False;
    private bool $spritFlag = False;
    private int $dollar = 1000;
    private int $bet = 0;
    private const DRAW = 1;
    private const STAND = 2;
    private const SURRENDER = 3;
    private const DOUBLE_DOWN = 4;
    private const SPRIT = 5;

    public function getPlayerInformation(): string
    {
        return $this->playerInformation;
    }
    //**************************************************************************
    public function answerAddCard(): string
    {
        return trim(fgets(STDIN));
    }
    //**************************************************************************

    public function answerAction(): int
    {
        return trim(fgets(STDIN));
    }

    public function answerBet(): void
    {
        $this->bet = trim(fgets(STDIN));
    }

    public function setBet(int $bet):void
    {
        $this->bet = $bet;
    }

    public function getDollar()
    {
        return $this->dollar;
    }

    public function betDollarCheck(): bool
    {
        if ($this->dollar - $this->bet < 0) {
            return False;
        }
        return True;
    }

    public function userAction(int $selectAction): int
    {
        $result = 0;
        if ($selectAction === self::DRAW) {
            $result = self::DRAW;
        } elseif ($selectAction === self::STAND) {
            $this->setStandFlag();
            $result = self::STAND;
        } elseif ($selectAction === self::SURRENDER) {
            $this->setSurrenderFlag();
            $this->bet /= 2;
            $result = self::SURRENDER;
        } elseif ($selectAction === self::DOUBLE_DOWN) {
            if ($this->checkDollar()) {
                $this->setDoubleDownFlag();
                $this->bet *= 2;
            }
            $result = self::DOUBLE_DOWN;
        } elseif ($selectAction === self::SPRIT && $this->checkSprit()) {
            if ($this->checkDollar()) {
                $this->setSpritFlag();
            }
            $result = self::SPRIT;
        }
        return $result;
    }

    public function getBet(): int
    {
        return $this->bet;
    }

    public function getStandFlag(): bool
    {
        return $this->standFlag;
    }

    public function getDoubleDownFlag(): bool
    {
        return $this->doubleDownFlag;
    }

    public function getSurrenderFlag(): bool
    {
        return $this->surrenderFlag;
    }

    public function getSpritFlag(): bool
    {
        return $this->spritFlag;
    }

    public function setStandFlag(): void
    {
        $this->standFlag = True;
    }

    public function setDoubleDownFlag(): void
    {
        $this->doubleDownFlag = True;
    }

    public function setSurrenderFlag(): void
    {
        $this->surrenderFlag = True;
    }

    public function setSpritFlag(): void
    {
        $this->spritFlag = True;
    }

    private function checkSprit(): bool
    {
        $result = False;
        if ($this->hands[0]->getNumber() === $this->hands[1]->getNumber()) {
            $result = True;
        }

        return $result;
    }

    public function checkDollar(): bool
    {
        $result = False;
        if ($this->dollar >= ($this->bet * 2)) {
            $result = True;
        }
        return $result;
    }

    public function setWinnerDollar(): void
    {
        $this->dollar += $this->bet;
    }
    public function setLooserDollar(): void
    {
        $this->dollar -= $this->bet;
    }
    public function doSprit():Card
    {
        return array_shift($this->hands);
    }
    public function setSpritCard(Card $card):void
    {
        $this->spritFlag = True;
        $this->hands[] = $card;
    }

    public function calcSprit():void
    {
        $this->sumPoint = 0;
        foreach($this->hands as $card){
            $this->sumPoint += $card->getNumber();
        }
    }
}
