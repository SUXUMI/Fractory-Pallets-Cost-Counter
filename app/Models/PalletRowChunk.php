<?php

namespace App\Models;

use App\Contracts\FillableShape;
use App\Contracts\Shape;

class PalletRowChunk extends Shape implements FillableShape
{
    protected bool $isFull = false;

    private Shape $item;

    private array $leftovers = [];

    public function fill(Shape $item): bool
    {
        if (! $this->isFull && $this->fitsIntoChunk($item)) {
            $this->item = $item;
            $this->isFull = true;

            $this->handleFittingProcess();

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

    public function getLeftoverChunks(): array
    {
        return $this->leftovers;
    }

    private function handleFittingProcess(): void
    {
        if (! isset($this->item))
            return;

        // calculate new chunks with their own dimensions
        $initial_length = $this->getLength();
        $initial_width = $this->getWidth();

        // change current dimensions
        $this->length = $this->item->getLength();
        $this->width = $this->item->getWidth();

        // calculate two new leftover chunks
        // @todo: improvement - there could be max 4 different pair of leftover chunks
        // @todo: and this could be even moved into the independent class e.g. geometry calculations or..
        // but now just quick solution:
        $max_initial = max($initial_length, $initial_width);
        $min_initial = min($initial_length, $initial_width);

        $max_current = max($this->length, $this->width);
        $min_current = min($this->length, $this->width);

        // dump("{$max_initial}, {$min_initial}, {$max_current}, {$min_current}");

        $first_chunk_length = $max_initial;
        $first_chunk_width = $min_initial - $min_current;

        // dump("{$first_chunk_length}:{$first_chunk_width}");

        $second_chunk_length = $max_initial - $max_current;
        $second_chunk_width =  $min_current;

        // dump("{$second_chunk_length}:{$second_chunk_width}");

        if (min($first_chunk_length, $first_chunk_width) > 0) {
            $this->leftovers[] = new static($first_chunk_length, $first_chunk_width, $this->getHeight());
        }

        if (min($second_chunk_length, $second_chunk_width) > 0) {
            $this->leftovers[] = new static($second_chunk_length, $second_chunk_width, $this->getHeight());
        }
    }

    /** Determine whether the item fits into the current chunk's dimensions */
    private function fitsIntoChunk(Item $item): bool
    {
        $minWidth = min($item->getLength(), $item->getWidth());
        $maxWidth = max($item->getLength(), $item->getWidth());

        if ($maxWidth > max($this->getLength(), $this->getWidth())) {
            return false;
        }

        if ($minWidth > min($this->getLength(), $this->getWidth())) {
            return false;
        }

        return true;
    }
}
