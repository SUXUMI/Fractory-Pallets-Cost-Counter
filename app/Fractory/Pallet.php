<?php

namespace App\Fractory;

class Pallet
{
    protected $width = 1200;
    protected $height = 1000;
    // protected $thick = 10;

    protected array $palletRows = [];

    public function __construct()
    {
        $this->fillUpRows();
    }

    public function fill(Item $item) {
        // @todo: optimize
        foreach ($this->palletRows as $palletRow) {
            $result = $palletRow->fill($item);

            if ($result) {
                return true;
            }
        }

        return false;
    }

    public function getPalletRows() {
        return $this->palletRows;
    }

    private function fillUpRows() {
        for ($i = 0; $i < 18; $i++) {
            $this->palletRows[] = new PalletRow();
        }
    }

    // @todo: optimize
    // private function createNewRow() {
    //
    // }
}
