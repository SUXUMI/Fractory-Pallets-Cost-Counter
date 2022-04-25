<?php

namespace App\Fractory;

class PalletRow
{
    protected $width = 1200;
    protected $height = 1000;
    // protected $thick = 10;
    protected $isFull = false;

    protected $items = [];

    // very very bad solution :)
    // @todo: need improvement
    public function fill(Item $item) {
        $this->validateItem($item);

        if (! $this->isFull) {
            $this->items[] = $item;
            $this->isFull = true;
            return true;
        }

        return false;
    }

    private function validateItem(Item $item) {
        $minWith = min($item->getWidth(), $item->getHeight());
        $maxWith = max($item->getWidth(), $item->getHeight());

        if ($maxWith > max($this->width, $this->height)) {
            throw new InvalidDimensions();
        }

        if ($minWith > min($this->width, $this->height)) {
            throw new InvalidDimensions();
        }
    }

    // public function getThick() {
    //
    // }

    public function isFull() {
        return $this->isFull;
    }
}
