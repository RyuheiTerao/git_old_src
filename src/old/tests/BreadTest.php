<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/Bread.php');

class BreadTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDisplayResult()
    {
        $output = <<<EOD
        2464
        1
        5 10

        EOD;
        $this->expectOutputString($output);

        $sales = chunkInput(['file', '1', '10', '2', '3', '5', '1', '7', '5', '10', '1']);
        $salesAmount = calculateSales($sales);
        $numbersOfMaxUnitsSold = getNumbersOfMaxUnitsSold($sales);
        $numbersOfMinUnitsSold = getNumbersOfMinUnitsSold($sales);
        displayResult([$salesAmount], $numbersOfMaxUnitsSold, $numbersOfMinUnitsSold);
    }
}
