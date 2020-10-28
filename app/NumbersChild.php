<?php

namespace App;


class NumbersChild extends Numbers
{
    public function sum()
    {
        $first = $this->numbers[0];
        $end = end($this->numbers);

        return $first + $end;
    }
}
