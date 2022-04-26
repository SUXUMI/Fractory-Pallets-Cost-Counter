<?php

namespace App\Contracts;

interface ContainersCounter
{
    public function addItem(int $length, int $width, int $height);

    public function getContainers();

    public function getContainersCount();
}
