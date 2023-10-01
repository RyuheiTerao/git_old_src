<?php

namespace Poker;

require_once('PokerCard.php');
require_once('PokerHandEvaluator.php');
require_once('PokerTwoCardRule.php');
require_once('PokerThreeCardRule.php');

class PokerGame
{
    public function __construct(private array $cards1, private array $cards2)
    {
    }

    public function start(): array
    {
        $hands = [];
        foreach ([$this->cards1, $this->cards2] as $cards) {
            $pokerCards = array_map(fn ($card) => new PokerCard($card), $cards);
            $rule = $this->getRule($cards);
            $handEvaluator = new PokerHandEvaluator($rule);
            $hands[] = $handEvaluator->getHand($pokerCards);
        }

        $result = [$hands[0]['role'], $hands[1]['role'], $handEvaluator->judgeWinner($hands)];

        return $result;
    }

    private function getRule(array $cards): PokerRule
    {
        $rule = new PokerTwoCardRule();
        if (count($cards) === 3) {
            $rule = new PokerThreeCardRule();
        }
        if (count($cards) === 5) {
            $rule = new PokerFiveCardRule();
        }
        return $rule;
    }
}
