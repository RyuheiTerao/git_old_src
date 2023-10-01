<?php

namespace Black_Jack;

require_once('Deck.php');
require_once('Card.php');

abstract class Player
{
    protected array $hands = [];
    protected int $sumPoint = 0;
    private bool $burstFlag = False;
    private int $countA = 0;

    public function drawCards(Deck $deck, int $drawNum): array
    {
        foreach ($deck->drawCards($drawNum) as $card) {
            $this->hands[] = $card;
            $this->calcPoint($card);
        }
        return $this->hands;
    }

    public function addCard(Deck $deck): array
    {
        $card = $deck->drawCards(1);
        $this->hands[] = $card[0];
        $this->calcPoint($card[0]);
        return $card;
    }

    public function getHands(): array
    {
        return $this->hands;
    }

    public function getPoint(): int
    {
        return $this->sumPoint;
    }

    private function calcPoint(Card $card): void
    {
        if ($this->checkJQK($card->getNumber())) {
            $this->sumPoint += 10;
        } elseif ($this->checkA($card->getNumber())) {
            $this->countA++;
            if ($this->sumPoint + 11 > 21) {
                $this->sumPoint += 1;
            } else {
                $this->sumPoint += 11;
            }
        } else {
            $this->sumPoint += $card->getNumber();
        }

        if ($this->burstCheck()) {
            $this->burstFlag = True;
        }
    }

    private function checkJQK(int $card): bool
    {
        return ($card === 11 || $card === 12 || $card === 13);
    }

    private function checkA(int $card): bool
    {
        return $card === 1;
    }

    private function burstCheck(): bool
    {
        $result = False;
        while ($this->sumPoint > 21 && $this->countA > 0) {
            $this->countA--;
            $this->sumPoint -= 10;
        }
        if ($this->sumPoint >= 21) {
            $result = True;
        }

        return $result;
    }

    public function getBurstFlag(): bool
    {
        return $this->burstFlag;
    }
}
