<?php

namespace App\Models;

use App\Contracts\FillableShape;
use App\Contracts\Shape;
use App\Exceptions\InvalidDimensions;

class Pallet extends Shape implements FillableShape
{
    // it is assumed that height of all items are the same
    protected int $palletRowHeight = 10;

    protected bool $isFull = false;

    protected array $rows = [];

    /**
     * @throws InvalidDimensions
     */
    public function fill(Shape $item): bool
    {
        $this->validateItem($item);

        if (!$this->rows) {
            // create empty rows for the just initiated/created pallet
            $this->defineRows();
        }

        $this->palletRowHeight = $item->getHeight();

        return $this->fillIntoTheFirstAvailableRow($item);
    }

    public function isFull(): bool
    {
        return $this->isFull;
    }

    public function getFilledItems(): array
    {
        return $this->rows;
    }

    private function fillIntoTheFirstAvailableRow(Item $item): bool
    {
        foreach ($this->rows as $palletRow) {
            $result = $palletRow->fill($item);

            if ($result) {
                return true;
            }
        }

        return false;
    }

    private function defineRows() {
        for ($i = 0, $n = $this->getHeight() / $this->palletRowHeight; $i < $n; $i++) {
            $this->rows[] = new PalletRow($this->getLength(), $this->getWidth(), $this->palletRowHeight);
        }
    }

    /**
     * Validates the item for the max allowed dimensions
     *
     * @param Item $item
     * @return void
     * @throws InvalidDimensions
     */
    private function validateItem(Item $item) {
        $minWidth = min($item->getLength(), $item->getWidth());
        $maxWidth = max($item->getLength(), $item->getWidth());

        if ($maxWidth > max($this->getLength(), $this->getWidth())) {
            throw new InvalidDimensions();
        }

        if ($minWidth > min($this->getLength(), $this->getWidth())) {
            throw new InvalidDimensions();
        }
    }
}
