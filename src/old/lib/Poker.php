<?php

require_once(__DIR__ . '/TwoCardPoker.php');
require_once(__DIR__ . '/ThreeCardPoker.php');

const TWO_CARD_POKER  = 2;
const THREE_CARD_POKER = 3;

function changeCardsToRankPoker(array $playerCards): array
{
    $cardsRank = [];
    foreach ($playerCards as $cards) {
        foreach ($cards as $card) {
            $cardsRank[] = CARD_RANK[substr($card, 1)];
        }
    }

    return $cardsRank;
}

function judgePoker(array $Cards): int
{
    if (count($Cards) === 2) {
        $result = TWO_CARD_POKER;
    } elseif (count($Cards) === 3) {
        $result = THREE_CARD_POKER;
    } else {
        $result = 0;
    }
    return $result;
}

function showResult(array $Player1Card, array $Player2Card): array
{
    $poker = judgePoker($Player1Card);

    // 手札をランクに変換する
    $HandsRank = changeCardsToRankPoker([$Player1Card, $Player2Card]);

    if ($poker === TWO_CARD_POKER) {
        $playerCardRanks = array_chunk($HandsRank, 2);
        $hands = array_map(fn ($playerCardRank) => checkHand($playerCardRank[0], $playerCardRank[1]), $playerCardRanks);

        //　勝者を判定する
        $winner = judgeWinner($hands);

        $result = [$hands[0]['role'], $hands[1]['role'], $winner];
    } elseif ($poker === THREE_CARD_POKER) {
        $playerCardRanks = array_chunk($HandsRank, 3);
        $hands = array_map(fn ($playerCardRank) => checkHands($playerCardRank[0], $playerCardRank[1], $playerCardRank[2]), $playerCardRanks);


        $winner = judgeWinnerThree($hands);

        $result = [$hands[0]['role'], $hands[1]['role'], $winner];
    }

    return $result;
}
