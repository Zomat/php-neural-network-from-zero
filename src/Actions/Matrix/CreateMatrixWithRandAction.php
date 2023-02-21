<?php

namespace App\Actions\Matrix;

use App\Math\Matrix;

class CreateMatrixWithRandAction
{
    public function handle(int $rows, int $cols, int $range = 1) : Matrix
    {
        $values = [];

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $values[$i][$j] = (float) rand(-$range*100, $range*100)/100;
            };
        };

        return new Matrix($values);
    }
}