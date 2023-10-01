<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/HitAndBlow.php');

class HitAndBlowTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function test()
    {
        $output1 = [4,0];
        $output2 = [1,1];
        $output3 = [0,4];
        $output4 = [0,0];

        $this->assertSame($output1, judge(5678,5678));
        $this->assertSame($output2, judge(5678,7612));
        $this->assertSame($output3, judge(5678,8756));
        $this->assertSame($output4, judge(5678,1234));
    }
}
