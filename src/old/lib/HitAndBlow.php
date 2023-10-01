<?php

function checkHitCount(array $CorrectAnswer, array $Answer): int
{
    $HitCount = 0;
    foreach($CorrectAnswer as $index => $num){
        if($num === $Answer[$index]){
            $HitCount++;
        }
    }
    return $HitCount;
}

function checkBlowCount(array $CorrectAnswer, array $Answer): int
{
    $BlowCount = 0;
    foreach($CorrectAnswer as $index => $num){
        if($num === $Answer[$index]){
            continue;
        }
        if(in_array($num, $Answer)){
            $BlowCount++;
        }
    }

    return $BlowCount;
}






function judge(int $CorrectAnswer, int $Answer): array
{
    $result = [];
    $CorrectAnswer = str_split((string)$CorrectAnswer);
    $Answer = str_split((string)$Answer);
    $HitCount = checkHitCount($CorrectAnswer, $Answer);
    $BlowCount = checkBlowCount($CorrectAnswer, $Answer);

    $result = [$HitCount,$BlowCount];

    return $result;
}
