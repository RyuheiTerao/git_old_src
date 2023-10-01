<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/SuperCalculate.php');

class SuperCalculateTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function test()
    {
        $output = 1298;
        $this->assertSame($output, calc('21:00',[1,1,1,3,5,7,8,9,10]));
    }
}
