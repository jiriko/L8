<?php

namespace App;


class Numbers
{
    protected $numbers;

    const ASC = 'asc';

    public function __construct($numbers = null)
    {
        $this->numbers = $numbers ?: $this->randomNumbers();
    }

    public function sum()
    {
        $random = array_rand($this->numbers, 2);
        return array_sum(array_intersect_key($this->numbers, $random));
    }

    public function sort($sort)
    {
        if ($sort == SELF::ASC) {
            sort($this->numbers);
            return $this->numbers;
        }

        rsort($this->numbers);
        return $this->numbers;
    }

    public function avg()
    {
        return array_sum($this->numbers) / count($this->numbers);
    }

    protected function randomNumbers()
    {
        $numbers = [];
        for ($i = 0; $i < 10; $i++) {
            array_push($numbers, mt_rand());
        }

        return $numbers;
    }
}
