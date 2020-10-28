<?php

namespace Tests\Unit;

use App\Numbers;
use PHPUnit\Framework\TestCase;

class NumbersTest extends TestCase
{
    /**
     * @group numbers
     *
     * @test
     */
    public function it_picks_two_numbers_and_their_sum()
    {
        $numbers = new Numbers([1, 3]);

        $this->assertEquals(4, $numbers->sum());
    }

    /**
     * @group numbers
     *
     * @test
     */
    public function it_sorts_the_array()
    {
        $numbers = new Numbers([4, 1, 3]);

        $this->assertEquals([1, 3, 4], $numbers->sort('asc'));
        $this->assertEquals([4, 3, 1], $numbers->sort('desc'));
    }

     /**
     * @group numbers
     *
     * @test
     */
    public function it_avgs_the_array()
    {
        $numbers = new Numbers([8, 2, 2]);

        $this->assertEquals(4, $numbers->avg());
    }
}
