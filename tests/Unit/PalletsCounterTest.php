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

        // each pallet, by default, is 1800 mm in height,
        // each item, by default, is 10 mm in height, (could be anything else, but the same per each item)
        // so on each pallet min 180 (1800 / 10) items should be fit
        $n = rand(1, 35);
        for($i = 0; $i < 180 * $n; $i++) {
            $length = rand(1, 1200);
            $width = rand(1, 1000);
            $palletsCounter->addItem($length, $width);
        }

        // dump("{$n}, {$palletsCounter->getContainersCount()}");

        $this->assertLessThanOrEqual($n, $palletsCounter->getContainersCount());
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
