<?php

namespace App\Services;

use App\Contracts\ContainersCounter;
use App\Exceptions\InvalidDimensions;
use App\Models\Item;
use App\Models\Pallet;

class FractoryContainersCounter implements ContainersCounter
{
    protected array $items = [];
    protected array $pallets = [];

    function addItem(int $length, int $width, int $height = 10)
    {
        $item = new Item($length, $width, $height);

        $this->items[] = $item;

        // add item into the list
        try {
            $this->fill($item);
        }
        catch (InvalidDimensions $e) {
            $item->setIsValid(false);
        }
    }

    /**
     * Gets Pallets list
     *
     * @return array
     */
    public function getContainers(): array
    {
        return $this->pallets;
    }

    /**
     * Gets total pallets used
     *
     * @return int
     */
    public function getContainersCount(): int
    {
        return count($this->pallets);
    }

    /**
     * Fill up the pallet with items
     *
     * @throws InvalidDimensions
     */
    private function fill(Item $item): void
    {
        foreach ($this->pallets as $pallet) {
            $result = $pallet->fill($item);

            if ($result) {
                return;
            }
        }

        // try to create a new empty pallet
        $this->createNewPallet()->fill($item);
    }

    /**
     * Creates new empty pallet
     * @return Pallet
     */
    private function createNewPallet(): Pallet
    {
        $pallet = new Pallet(1200, 1000, 1800);

        $this->pallets[] = $pallet;

        return $pallet;
    }
}
