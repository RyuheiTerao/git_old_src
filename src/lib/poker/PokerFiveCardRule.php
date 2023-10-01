<?php

namespace Poker;

require_once('PokerCard.php');
require_once('PokerRule.php');

class PokerFiveCardRule implements PokerRule
{
    private const HIGH_CARD = 'high card';
    private const ONE_PAIR = 'one pair';
    private const TWO_PAIR = 'two pair';
    private const THREE_OF_A_KIND = 'three of a kind';
    private const STRAIGHT = 'straight';
    private const FULL_HOUSE = 'full house';
    private const FOUR_OF_A_KIND = 'four of a kind';

    public function getHand(array $pokerCards): string
    {
        $cardRanks = array_map(fn ($pokerCard) => $pokerCard->getRank(), $pokerCards);
        sort($cardRanks);
        $name = self::HIGH_CARD;
        if ($this->isFourOfAKind($cardRanks)) {
            $name = self::FOUR_OF_A_KIND;
        } elseif ($this->isFullHouse($cardRanks)) {
            $name = self::FULL_HOUSE;
        } elseif ($this->isStraight($cardRanks)) {
            $name = self::STRAIGHT;
        } elseif ($this->isThreeOfAKind($cardRanks)) {
            $name = self::THREE_OF_A_KIND;
        } elseif ($this->isTwoPair($cardRanks)) {
            $name = self::TWO_PAIR;
        } elseif ($this->isOnePair($cardRanks)) {
            $name = self::ONE_PAIR;
        }

        return $name;
    }

    private function isFourOfAKind(array $cardRanks): bool
    {
        return count(array_unique(array_slice($cardRanks, 0, 4))) === 1 || count(array_unique(array_slice($cardRanks, 1, 4))) === 1;
    }

    private function isFullHouse(array $cardRanks): bool
    {
        return (count(array_unique(array_slice($cardRanks, 0, 3))) === 1 && count(array_unique(array_slice($cardRanks, 3, 2))) === 1)
            || (count(array_unique(array_slice($cardRanks, 0, 2))) === 1 && count(array_unique(array_slice($cardRanks, 2, 3))) === 1);
    }

    private function isStraight(array $cardRanks): bool
    {
        return range($cardRanks[0], $cardRanks[0] + count($cardRanks) - 1) === $cardRanks || $this->isFirstStraight($cardRanks);
    }

    private function isFirstStraight(array $cardRanks): bool
    {
        return $cardRanks === [min(PokerCard::CARD_RANK), min(PokerCard::CARD_RANK) + 1, min(PokerCard::CARD_RANK) + 2, min(PokerCard::CARD_RANK) + 3, max(PokerCard::CARD_RANK)];
    }

    private function isThreeOfAKind(array $cardRanks): bool
    {
        return count(array_unique(array_slice($cardRanks, 0, 3))) === 1
            || count(array_unique(array_slice($cardRanks, 1, 3))) === 1
            || count(array_unique(array_slice($cardRanks, 2, 3))) === 1;
    }


    private function isTwoPair(array $cardRanks): bool
    {
        return (count(array_unique(array_slice($cardRanks, 0, 2))) === 1 && count(array_unique(array_slice($cardRanks, 2, 2))) === 1)
            || (count(array_unique(array_slice($cardRanks, 0, 2))) === 1 && count(array_unique(array_slice($cardRanks, 3, 2))) === 1)
            || (count(array_unique(array_slice($cardRanks, 1, 2))) === 1 && count(array_unique(array_slice($cardRanks, 3, 2))) === 1);
    }

    private function isOnePair(array $cardRanks): bool
    {
        return count(array_unique($cardRanks)) === 4;
    }
    public function judgeWinner(array $hands): int
    {
        $winner = 0;
        foreach (['roleRank', 'primary', 'secondary'] as $key) {
            if ($hands[0][$key] > $hands[1][$key]) {
                $winner = 1;
                break;
            }
            if ($hands[0][$key] < $hands[1][$key]) {
                $winner = 2;
                break;
            }
        }
        return $winner;
    }
}
