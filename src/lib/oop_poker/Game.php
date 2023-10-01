<?php

namespace OopPoker;


require_once('Player.php');
require_once('Deck.php');
require_once('RuleA.php');
require_once('RuleB.php');
require_once('HandEvaluator.php');


class Game
{
    public function __construct(private string $name1, private string $name2, private int $drawNum, private string $ruleType)
    {
    }

    function start()
    {
        $deck = new Deck();
        $rule = $this->getRule();
        $handEvaluator = new HandEvaluator($rule);
        $hands = [];

        foreach ([$this->name1, $this->name2] as $name) {
            $player = new Player($name);
            $cards = $player->drawCards($deck, $this->drawNum);
            $hands[] = $handEvaluator->getHand($cards);
        }

        return HandEvaluator::getWinner($hands[0], $hands[1]);
    }
    private function getRule()
    {
        if ($this->ruleType === 'A') {
            return new RuleA();
        }
        if ($this->ruleType === 'B') {
            return new RuleB();
        }
        if ($this->ruleType === 'C') {
            return new RuleC();
        }
    }
}
