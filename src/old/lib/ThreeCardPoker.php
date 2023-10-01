<?php

require_once(__DIR__ . '/TwoCardPoker.php');

const THREE_CARD = 'three card';

const ROLE_RANK_THREE = [
    'high card' => 0,
    'pair' => 1,
    'straight' => 2,
    'three card' => 3,
];

function changeCardsToRank(array $cards): array
{
    $cardsRank = [];
    foreach ($cards as $card) {
        $cardsRank[] = CARD_RANK[substr($card, 1)];
    }

    return $cardsRank;
}

function checkHands(int $card1, int $card2, int $card3): array
{
    $role = HIGH_CARD;
    $cardsPower = judgeCardPower([$card1, $card2, $card3]);

    if (isThreeCard($cardsPower)) {
        $role = THREE_CARD;
    } elseif (isPairThree($cardsPower)) {
        $role = PAIR;
    } elseif (isStraightThree($cardsPower)) {
        $role = STRAIGHT;
        if (isMinMaxThree($cardsPower)) {
            $primary = $cardsPower['primary'];
            $cardsPower['primary'] = $cardsPower['secondary'];
            $cardsPower['secondary'] = $cardsPower['tertiary'];
            $cardsPower['tertiary'] = $primary;
        }
    }



    return [
        'role' => $role,
        'roleRank' => ROLE_RANK_THREE[$role],
        'primary' => $cardsPower['primary'],
        'secondary' => $cardsPower['secondary'],
        'tertiary' => $cardsPower['tertiary'],
    ];
}

function judgeCardPower(array $cards): array
{
    $primary = max($cards);
    $tertiary = min($cards);
    $totalCardRank = 0;
    foreach ($cards as $card) {
        $totalCardRank += $card;
    }
    $secondary = $totalCardRank - $primary - $tertiary;

    return [
        'primary' => $primary,
        'secondary' => $secondary,
        'tertiary' => $tertiary,
    ];
}
function isThreeCard(array $cards): bool
{
    return $cards['primary'] === $cards['secondary'] && $cards['secondary'] === $cards['tertiary'];
}

function isPairThree(array $cards): bool
{
    return $cards['primary'] === $cards['secondary'] || $cards['primary'] === $cards['tertiary'] || $cards['secondary'] === $cards['tertiary'];
}

function isStraightThree(array $cards): bool
{
    return (abs($cards['primary'] - $cards['secondary']) === 1 && abs($cards['secondary'] - $cards['tertiary']) === 1) || isMinMaxThree($cards);
}

function isMinMaxThree(array $cards): bool
{
    return $cards['primary'] - ($cards['secondary'] + $cards['tertiary']) === 11;
}

function judgeWinnerThree(array $hands): int
{
    foreach (['roleRank', 'primary', 'secondary', 'tertiary'] as $key) {
        if ($hands[0][$key] > $hands[1][$key]) {
            return 1;
        }
        if ($hands[0][$key] < $hands[1][$key]) {
            return 2;
        }
    }
    return 0;
}




function show(string $Player1Card1, string $Player1Card2, string $Player1Card3, string $Player2Card1, string $Player2Card2, string $Player2Card3,): array
{
    // 手札をランクに変換する
    $HandsRank = changeCardsToRank([$Player1Card1, $Player1Card2, $Player1Card3, $Player2Card1, $Player2Card2, $Player2Card3]);

    //　役を決める
    $playerCardRanks = array_chunk($HandsRank, 3);
    $hands = array_map(fn ($playerCardRank) => checkHands($playerCardRank[0], $playerCardRank[1], $playerCardRank[2]), $playerCardRanks);

    //　勝者を判定する
    $winner = judgeWinnerThree($hands);

    $result = [$hands[0]['role'], $hands[1]['role'], $winner];

    return $result;
}
