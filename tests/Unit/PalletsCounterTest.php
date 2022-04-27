<?php


namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class PalletsCounterTest extends TestCase
{
    /** @test */
    public function it_checks_if_pallets_for_items_counted_in_a_reasonable_way()
    {
        /** @var \App\Services\FractoryContainersCounter $palletsCounter */
        $palletsCounter = resolve(\App\Contracts\ContainersCounter::class);

        $row_height = 450; // 1/4 of the pallet's height (thickness)

        $palletsCounter->addItem(800, 1200, $row_height);
        $palletsCounter->addItem(100, 900, $row_height);
        $palletsCounter->addItem(300, 600, $row_height);
        $palletsCounter->addItem(55, 100, $row_height);
        $palletsCounter->addItem(110, 75, $row_height);
        $palletsCounter->addItem(100, 100, $row_height);
        $palletsCounter->addItem(100, 100, $row_height);
        $palletsCounter->addItem(100, 100, $row_height);
        $palletsCounter->addItem(100, 100, $row_height);
        $palletsCounter->addItem(900, 500, $row_height);
        $palletsCounter->addItem(100, 750, $row_height);
        $palletsCounter->addItem(600, 500, $row_height);
        $palletsCounter->addItem(400, 500, $row_height);

        $this->assertLessThanOrEqual(1, $palletsCounter->getContainersCount());
    }
}









//
// namespace Tests\Unit;
//
// use PHPUnit\Framework\TestCase;
//
// class PalletsCounter extends TestCase
// {
//     /**
//      */
//     public function test_that_true_is_true()
//     {
//         $this->expectException();
//
//         $palletsCounter = app()->make(\App\Contracts\ContainersCounter::class);
//
//         var_dump($palletsCounter);
//         // dd($palletsCounter);
//
//         // $this->assertTrue(true);
//     }
// }
