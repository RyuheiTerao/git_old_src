<?php

namespace VendingMachine;

require_once('Item.php');

class Snack extends Item
{
    private const PRICES = [
        'potato chips' => 150,
    ];

    private const STOCK = [
        'potato chips' =>50,
    ];

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function getPrice(): int
    {
        return self::PRICES[$this->name];
    }

    public function getCupNumber(): int
    {
        return 0;
    }

    public function getStock(): int
    {
        return self::STOCK[$this->name];
    }
}
