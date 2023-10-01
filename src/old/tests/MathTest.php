<?php

use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    // @phpstan-ignore-next-line
    public function testDouble()
    {
        require_once(__DIR__ . '/../lib/Math.php');
        $this->assertSame(4, double(2));
    }
}
