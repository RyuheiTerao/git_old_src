<?php

namespace VendingMachine;

require_once(__DIR__ . '/Item.php');

class VendingMachine
{
    private const MAX_CUP_NUMBER = 100;

    private int $depositedCoin = 0;
    private int $cupNumber = 0;
    private $stock = [
        'cider' => 0,
        'cola' => 0,
        'ice cup coffee' => 0,
        'hot cup coffee' => 0,
        'potato chips' => 0,
    ];

    public function depositCoin(int $coinAmount): int
    {
        if ($coinAmount === 100) {
            $this->depositedCoin += $coinAmount;
        }

        return $this->depositedCoin;
    }

    private function inventoryCheck(Item $item): bool
    {
        if ($this->stock[$item->getName()] >= 1) {
            $this->stock[$item->getName()] = $this->stock[$item->getName()] - 1;
            return true;
        }
        return false;
    }


    public function pressButton(Item $item): string
    {
        $price = $item->getPrice();
        $cupNumber = $item->getCupNumber();
        if ($this->depositedCoin >= $price && $this->cupNumber >= $cupNumber && $this->inventoryCheck($item)) {
            $this->depositedCoin -= $price;
            $this->cupNumber -= $cupNumber;
            return $item->getName();
        } else {
            return '';
        }
    }

    public function depositItem(Item $item, int $num):int
    {
        $this->stock[$item->getName()] += $num;
        if($this->stock[$item->getName()] > $item->getStock()){
            $this->stock[$item->getName()] = $item->getStock();
        }
        return $this->stock[$item->getName()] = $item->getStock();
    }

    public function receiveChange(): int
    {
        $returnChange = $this->depositedCoin;
        $this->depositedCoin = 0;
        return $returnChange;
    }

    public function addCup(int $num): int
    {
        $cupNumber = $this->cupNumber + $num;

        if ($cupNumber > self::MAX_CUP_NUMBER) {
            $cupNumber = self::MAX_CUP_NUMBER;
        }

        $this->cupNumber = $cupNumber;
        return $this->cupNumber;
    }
}
