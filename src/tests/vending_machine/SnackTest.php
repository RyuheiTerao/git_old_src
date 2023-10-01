<?php

namespace VendingMachine\Tests;

use PHPUnit\Framework\TestCase;
use VendingMachine\Snack;

require_once(__DIR__ . '/../../lib/vending_machine/Snack.php');

class SnackTest extends TestCase
{
    public function testGetPrice()
    {
        $snack = new Snack('potato chips');
        $this->assertSame(150, $snack->getPrice());
    }

    public function testGetName()
    {
        $snack = new Snack('potato chips');
        $this->assertSame('potato chips', $snack->getName());
    }

    public function testGetCupNumber()
    {
        $snack = new Snack('potato chips');
        $this->assertSame(0, $snack->getCupNumber());
    }
}
