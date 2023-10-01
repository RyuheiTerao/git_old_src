<?php

function judeTimeSale(string $time): bool
{
    return ((strtotime($time) >= strtotime('20:00')) && (strtotime($time) <= strtotime('23:00')));
}

function countOnion(array $inputs): int
{
    $OnionCount = 0;
    $price = 0;
    foreach ($inputs as $input) {
        if ($input === 1) {
            $OnionCount++;
            if ($OnionCount === 3) {
                $price += 50;
            }
            if ($OnionCount === 5) {
                $price += 50;
            }
        }
    }
    return $price;
}


const COMMODITY = [
    1 => 100,
    2 => 150,
    3 => 200,
    4 => 350,
    5 => 180,
    6 => 220,
    7 => 440,
    8 => 380,
    9 => 80,
    10 => 100,
];

// @phpstan-ignore-next-line
function calc(string $time, array $inputs): int
{
    $timeSaleFlag = judeTimeSale($time);
    $onionDiscount = countOnion($inputs);


    $sum = 0;

    $LunchBoxCount = 0;
    $DrinkCount = 0;
    foreach ($inputs as $input) {
        $price = COMMODITY[$input];
        if ($input === 7 || $input === 8) {
            $LunchBoxCount++;
            if ($timeSaleFlag === True) {
                $price = COMMODITY[$input] / 2;
            }
        }
        if ($input === 9 || $input === 10) {
            $DrinkCount++;
        }

        $sum += $price;
    }
    $SetDiscount = 0;
    while ($LunchBoxCount > 0 && $DrinkCount > 0) {
        $LunchBoxCount--;
        $DrinkCount--;
        $SetDiscount += 20;
    }
    $sum -= $SetDiscount + $onionDiscount;
    return (int)($sum * 110) / 100;
}

echo calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]) . PHP_EOL;
