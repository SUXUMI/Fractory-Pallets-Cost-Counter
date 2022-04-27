<?php

namespace App\Models;

use App\Contracts\FillableShape;
use App\Contracts\Shape;

class PalletRow extends Shape implements FillableShape
{
    protected bool $isFull = false;

    protected array $chunks = [];

    public function fill(Shape $item): bool
    {
        if (!$this->chunks) {
            // create empty rows for the just initiated/created pallet
            $this->defineChunks();
        }

        return $this->fillIntoTheFirstAvailableRow($item);
    }

    public function isFull(): bool
    {
        return $this->isFull;
    }

    public function getFilledItems(): array
    {
        return $this->chunks;
    }

    private function fillIntoTheFirstAvailableRow(Item $item): bool
    {
        foreach ($this->chunks as $chunk) {
            /** @var $chunk PalletRowChunk */
            $result = $chunk->fill($item);

            if ($result) {
                // append leftover chunks
                array_push($this->chunks, ...$chunk->getLeftoverChunks());

                return true;
            }
        }

        return false;
    }

    private function defineChunks() {
        $this->chunks[] = new PalletRowChunk($this->getLength(), $this->getWidth(), $this->getHeight());
    }
}
