<?php

namespace App\Fractory;

class Service
{
    protected $items = [];
    protected $pallets = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->items[] = new Item((int)$item[0], (int)$item[1]);
        }

        // create one empty pallet at least
        if (count($this->items)) {
            $this->createNewPallet();
        }
    }

    public function fillUpPallets() {
        foreach ($this->items as $item) {
            $this->fillUpPallet($item);
        }
    }

    private function fillUpPallet(Item $item) {
        foreach ($this->pallets as $pallet) {
            $result = $pallet->fill($item);

            if ($result)
                return true;
        }

        // try to create a new empty pallet
        $this->createNewPallet()->fill($item);
    }

    public function getPallets() {
        return $this->pallets;
    }

    public function getItems() {
        return $this->items;
    }

    private function createNewPallet() {
        $pallet = new Pallet();

        $this->pallets[] = $pallet;

        return $pallet;
    }
}
