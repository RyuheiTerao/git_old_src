<?php

const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';


const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A',];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $index => $card) {
        $cardRanks[$card] = $index;
    }
    return $cardRanks;
})());

const ROLE_RANK = [
    'high card' => 0,
    'pair' => 1,
    'straight' => 2,
];

function changeCardToRank(array $cards): array
{
    $cardsRank = [];
    foreach ($cards as $card) {
        $cardsRank[] = CARD_RANK[substr($card, 1)];
    }

    return $cardsRank;
}

function checkHand(int $card1, int $card2): array
{
    $role = HIGH_CARD;
    $primary = max([$card1, $card2]);
    $secondary = min([$card1, $card2]);

    if (isPair($primary, $secondary)) {
        $role = PAIR;
    }
    if (isStraight($primary, $secondary)) {
        $role = STRAIGHT;
        if(isMinMax($card1, $card2)){
            $primary = min([$card1, $card2]);
            $secondary = max([$card1, $card2]);
        }
    }



    return [
        'role' => $role,
        'roleRank' => ROLE_RANK[$role],
        'primary' => $primary,
        'secondary' => $secondary,
    ];
}

function isPair(int $card1, int $card2): bool
{
    return $card1 === $card2;
}

function isStraight(int $card1, int $card2): bool
{
    return abs($card1 - $card2) === 1 || isMinMax($card1, $card2);
}

function isMinMax(int $card1, int $card2): bool
{
    return abs($card1 - $card2) === (int)abs(max(CARD_RANK) - min(CARD_RANK));
}

function judgeWinner(array $hands): int
{
    foreach (['roleRank', 'primary', 'secondary'] as $key) {
        if ($hands[0][$key] > $hands[1][$key]) {
            return 1;
        }
        if ($hands[0][$key] < $hands[1][$key]) {
            return 2;
        }
    }
    return 0;
}




function showDown(string $Player1Card1, string $Player1Card2, string $Player2Card1, string $Player2Card2,): array
{
    // 手札をランクに変換する
    $HandsRank = changeCardToRank([$Player1Card1, $Player1Card2, $Player2Card1, $Player2Card2]);

    //　役を決める
    $playerCardRanks = array_chunk($HandsRank, 2);
    $hands = array_map(fn ($playerCardRank) => checkHand($playerCardRank[0], $playerCardRank[1]), $playerCardRanks);

    //　勝者を判定する
    $winner = judgeWinner($hands);

    $result = [$hands[0]['role'], $hands[1]['role'], $winner];

    return $result;
}






// const CARDS = [
//     1 => 'A',
//     2 => '2',
//     3 => '3',
//     4 => '4',
//     5 => '5',
//     6 => '6',
//     7 => '7',
//     8 => '8',
//     9 => '9',
//     10 => '10',
//     11 => 'J',
//     12 => 'Q',
//     13 => 'K',
//     14 => 'A',
// ];

// const ROLE_POWER = [
//     'high card',
//     'pair',
//     'straight',
// ];

// function judgeRole(string $Card1, string $Card2): string
// {
//     $Role = 'high card';
//     $Card1 = substr($Card1, 1);
//     $Card2 = substr($Card2, 1);



//     if (judgeRolePair($Card1, $Card2)) {
//         $Role = 'pair';
//     }
//     if (judgeRoleStraight($Card1, $Card2)) {
//         $Role = 'straight';
//     }
//     return $Role;
// }

// function judgeRolePair(string $Card1Number, string $Card2Number): bool
// {
//     return $Card1Number === $Card2Number;
// }

// function judgeRoleStraight(string $Card1Number, string $Card2Number): bool
// {
//     $Card1Key = array_search($Card1Number, CARDS);
//     if($Card1Key === 1){
//         return CARDS[$Card1Key + 1] === $Card2Number || CARDS[$Card1Key] === CARDS[array_search($Card2Number, CARDS) + 1];
//     }
//     return CARDS[$Card1Key + 1] === $Card2Number || CARDS[$Card1Key - 1] === $Card2Number || CARDS[$Card1Key] === CARDS[array_search($Card2Number, CARDS) + 1];
// }

// function judgeWinnerRolePlayer(string $Player1Role, string $Player2Role): int
// {
//     $Player1RolePower = array_search($Player1Role, ROLE_POWER);
//     $Player2RolePower = array_search($Player2Role, ROLE_POWER);

//     if ($Player1RolePower > $Player2RolePower) {
//         $WinnerPlayer = 1;
//     } elseif ($Player1RolePower < $Player2RolePower) {
//         $WinnerPlayer = 2;
//     } else {
//         $WinnerPlayer = 0;
//     }

//     return $WinnerPlayer;
// }

// function judgeWinnerCardPowerPlayer(string $Player1Cards1, string $Player1Cards2, string $Player2Cards1, string $Player2Cards2): int
// {
//     $WinnerPlayer = 0;

//     $Player1CardMaxPower = max([array_search(substr($Player1Cards1, 1), array_slice(CARDS, 1, null,true)), array_search(substr($Player1Cards2, 1), array_slice(CARDS, 1, null,true))]);
//     $Player2CardMaxPower = max([array_search(substr($Player2Cards1, 1), array_slice(CARDS, 1, null,true)), array_search(substr($Player2Cards2, 1), array_slice(CARDS, 1, null,true))]);
//     $Player1CardMinPower = min([array_search(substr($Player1Cards1, 1), array_slice(CARDS, 1, null,true)), array_search(substr($Player1Cards2, 1), array_slice(CARDS, 1, null,true))]);
//     $Player2CardMinPower = min([array_search(substr($Player2Cards1, 1), array_slice(CARDS, 1, null,true)), array_search(substr($Player2Cards2, 1), array_slice(CARDS, 1, null,true))]);

//     if(checkCardAPower($Player1CardMaxPower,$Player1CardMinPower)){
//         $Player1CardMaxPower = 2;
//         $Player1CardMinPower = 1;
//     }
//     if(checkCardAPower($Player2CardMaxPower,$Player2CardMinPower)){
//         $Player2CardMaxPower = 2;
//         $Player2CardMinPower = 1;
//     }


//     if ($Player1CardMaxPower > $Player2CardMaxPower) {
//         $WinnerPlayer = 1;
//     } elseif ($Player1CardMaxPower < $Player2CardMaxPower) {
//         $WinnerPlayer = 2;
//     }
//     if ($Player1CardMaxPower === $Player2CardMaxPower) {
//         if ($Player1CardMinPower > $Player2CardMinPower) {
//             $WinnerPlayer = 1;
//         } elseif ($Player1CardMinPower < $Player2CardMinPower) {
//             $WinnerPlayer = 2;
//         }
//     }

//     return $WinnerPlayer;
// }

// function checkCardAPower(int $max,int $min):bool
// {
//     return ($max === 14 && $min === 2);
// }

// function showDown(string $Player1Cards1, string $Player1Cards2, string $Player2Cards1, string $Player2Cards2): array
// {
//     $result = [];
//     $Player1Role = judgeRole($Player1Cards1, $Player1Cards2);
//     $Player2Role = judgeRole($Player2Cards1, $Player2Cards2);

//     $WinnerPlayer = judgeWinnerRolePlayer($Player1Role, $Player2Role);
//     if ($WinnerPlayer === 0) {
//         $WinnerPlayer = judgeWinnerCardPowerPlayer($Player1Cards1, $Player1Cards2, $Player2Cards1, $Player2Cards2);
//     }

//     $result = [$Player1Role, $Player2Role, $WinnerPlayer];

//     return $result;
// }
