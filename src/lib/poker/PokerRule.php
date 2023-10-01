<?php

namespace Poker;

interface PokerRule
{
    public function getHand(array $cards);
    public function judgeWinner(array $hands);
}
