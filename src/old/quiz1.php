<?php

function getInput()
{
    $viewData = [];
    $inputs = array_slice($_SERVER['argv'], 1);
    $splitInputs = array_chunk($inputs, 2);
    foreach($splitInputs as $input){
        $viewData[$input[0]][] = $input[1];
    }
    return $viewData;
}

function listViewTVData($inputs)
{
    $viewTVSumTimes = 0;
    ksort($inputs);
    var_dump($inputs);

    foreach($inputs as $input){
        foreach($input as $min){
            $viewTVSumTimes += $min;
        }
    }
    echo round($viewTVSumTimes/60,1) . PHP_EOL;

    foreach($inputs as $ch => $mins){
        $viewTVChSumTimes = 0;
        $count = 0;
        foreach($mins as $min){
            $viewTVChSumTimes += $min;
            $count++;
        }
        echo $ch . ' ' . $viewTVChSumTimes . ' ' .  $count . PHP_EOL;
    }
}



$inputs = getInput();

listViewTVData($inputs);
