<?php

namespace Poker;

require_once('PokerCard.php');
require_once('PokerRule.php');

class PokerThreeCardRule implements PokerRule
{
    private const HIGH_CARD = 'high card';
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const THREE_OF_A_KIND = 'three card';
    private const ROLE_RANKS = [
        'high card' => 0,
        'pair' => 1,
        'straight' => 2,
        'three card' => 3,
    ];

    public function getHand(array $pokerCards): array
    {
        $cardRanks = array_map(fn ($pokerCard) => $pokerCard->getRank(), $pokerCards);
        rsort($cardRanks);
        $primary = $cardRanks[0];
        $secondary = $cardRanks[1];
        $tertiary = $cardRanks[2];
        $role = self::HIGH_CARD;
        if ($this->isThreeOfAKind($cardRanks)) {
            $role = self::THREE_OF_A_KIND;
        } elseif ($this->isStraight($cardRanks)) {
            $role = self::STRAIGHT;
        } elseif ($this->isPair($cardRanks)) {
            $role = self::PAIR;
        }
        if ($this->isMinMax($cardRanks)) {
            $primary = $cardRanks[1];
            $secondary = $cardRanks[2];
            $tertiary = 0;
        }

        return [
            'role' => $role,
            'roleRank' => self::ROLE_RANKS[$role],
            'primary' => $primary,
            'secondary' => $secondary,
            'tertiary' => $tertiary,
        ];
    }

    private function isThreeOfAKind(array $cardRanks): bool
    {
        return count(array_unique($cardRanks)) === 1;
    }

    private function isStraight(array $cardRanks): bool
    {
        sort($cardRanks);
        return range($cardRanks[0], $cardRanks[0] + count($cardRanks) - 1) === $cardRanks || $this->isMinMax($cardRanks);
    }

    private function isMinMax(array $cardRanks): bool
    {
        sort($cardRanks);
        return $cardRanks === [min(PokerCard::CARD_RANK), min(PokerCard::CARD_RANK) + 1, max(PokerCard::CARD_RANK)];
    }

    private function isPair(array $cardRanks): bool
    {
        return count(array_unique($cardRanks)) === 2;
    }

    public function judgeWinner(array $hands): int
    {
        $winner = 0;
        foreach (['roleRank', 'primary', 'secondary', 'tertiary'] as $key) {
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
