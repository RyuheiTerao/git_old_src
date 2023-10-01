<?php

//無名関数
function convertToNumber(string ...$cards): array
{
    $result = array_map(function ($card) {
        return substr($card, 1);
    }, $cards);
    return $result;
}

//アロー関数
function convertToNumberByArrow(string ...$cards): array
{
    $result = array_map(fn($card)=>substr($card,1),$cards);
    return $result;
}
