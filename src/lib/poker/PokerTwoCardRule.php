<?php

namespace Poker;

require_once('PokerCard.php');
require_once('PokerRule.php');

class PokerTwoCardRule implements PokerRule
{
    private const HIGH_CARD = 'high card';
    private const PAIR = 'pair';
    private const STRAIGHT = 'straight';
    private const ROLE_RANKS = [
        'high card' => 0,
        'pair' => 1,
        'straight' => 2,
    ];
    public function getHand(array $pokerCards): array
    {
        $cardRanks = array_map(fn ($pokerCard) => $pokerCard->getRank(), $pokerCards);
        $role = self::HIGH_CARD;
        $primary = max($cardRanks);
        $secondary = min($cardRanks);

        if ($this->isStraight($cardRanks[0], $cardRanks[1])) {
            $role = self::STRAIGHT;
        } elseif ($this->isPair($cardRanks[0], $cardRanks[1])) {
            $role = self::PAIR;
        }
        if ($this->isMinMax($primary, $secondary)) {
            $primary = min($cardRanks);
            $secondary = 0;
        }

        return [
            'role' => $role,
            'roleRank' => self::ROLE_RANKS[$role],
            'primary' => $primary,
            'secondary' => $secondary,
        ];
    }

    private function isStraight(int $cardRank1, int $cardRank2): bool
    {
        return abs($cardRank1 - $cardRank2) === 1 || $this->isMinMax($cardRank1, $cardRank2);
    }

    private function isMinMax(int $cardRank1, int $cardRank2): bool
    {
        return abs($cardRank1 - $cardRank2) === (max(PokerCard::CARD_RANK) - min(PokerCard::CARD_RANK));
    }

    private function isPair(int $cardRank1, int $cardRank2): bool
    {
        return $cardRank1 === $cardRank2;
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
