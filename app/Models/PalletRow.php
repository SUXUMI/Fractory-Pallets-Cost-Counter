<?php

namespace App\Models;

use App\Contracts\FillableShape;
use App\Contracts\Shape;

class PalletRow extends Shape implements FillableShape
{
    protected bool $isFull = false;

    protected array $items = [];

    public function fill(Shape $item): bool
    {
        if (! $this->isFull) {
            $this->items[] = $item;
            $this->isFull = true;
            return true;
        }

        return false;
    }

    public function isFull(): bool
    {
        return $this->isFull;
    }

    public function getFilledItems(): array
    {
        return $this->items;
    }
}
