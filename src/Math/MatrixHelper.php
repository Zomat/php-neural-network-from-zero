<?php

declare(strict_types=1);

namespace App\Math;

use Exception;

class MatrixHelper
{
    public function validateSize(array $values) : void
    {
        if (count($values) == 0 || count($values[0]) == 0) {
            throw new Exception('Matrix can\'t be empty');
            return;
        }

        $valuesInRow = count($values[0]);
        foreach ($values as $row) {
            if ($valuesInRow != count($row)) {
                throw new Exception('Different number of elements in row');
                return;
            }
        }
    }

    public function validateSizes(Matrix $m1, Matrix $m2)
    {
        if ($m1->getRows() != $m2->getRows() || $m1->getCols() != $m2->getCols()) {
            throw new Exception("Cannot operate with matrixes with different sizes ({$m1->getRows()}, {$m1->getCols()})({$m2->getRows()}, {$m2->getCols()})");
            return;
        }
    }

    public function validateSizesForDotProduct(Matrix $m1, Matrix $m2)
    {
        if ($m1->getCols() != $m2->getRows()) {
            throw new Exception("Cannot dot product matrixes with sizes ({$m1->getRows()}, {$m1->getCols()})({$m2->getRows()}, {$m2->getCols()})");
            return;
        }
    }
    
}