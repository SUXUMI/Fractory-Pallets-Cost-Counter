<?php

namespace App\Contracts;

interface FillableShape
{
    public function fill(Shape $item): bool;

    public function getFilledItems(): array;

    public function isFull(): bool;
}
