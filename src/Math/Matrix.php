<?php

declare(strict_types=1);

namespace App\Math;

use Exception;

class Matrix
{
    private array $values;

    private int $rows;
    private int $cols;

    private MatrixHelper $matrixHelper;

    public function __construct(array $values)
    {
        $this->matrixHelper = new MatrixHelper();

        try {
            $this->matrixHelper->validateSize($values);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        $this->values = $values;

        $this->rows = count($values);
        $this->cols = count($values[0]);
    }


    public function getRows() : int
    {
        return $this->rows;
    }

    public function getCols() : int
    {
        return $this->cols;
    }

    public function getValue(int $i, int $j)
    {
        return $this->values[$i][$j];
    }

    public function printValues()
    {
        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
                echo $this->values[$i][$j] . ' ';
            }
            echo PHP_EOL;
        }
    }

    protected function validateEqualSizes($matrix)
    {
        if ($matrix instanceof Matrix) {
            try {
                $this->matrixHelper->validateSizes($this, $matrix);
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
    }

    protected function validateSizesForDotProduct($matrix)
    {
        try {
            $this->matrixHelper->validateSizesForDotProduct($this, $matrix);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function add(float|Matrix $val) : Matrix
    {
        if ($val instanceof Matrix) {
            $this->validateEqualSizes($val);
        }
    
        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
                if (is_float($val)) {
                    $this->values[$i][$j] += $val;
                } else {
                    $this->values[$i][$j] += $val->getValue($i, $j);
                }
            }
        }

        return $this;
    }

    public function sub(float|Matrix $val) : Matrix
    { 
        if ($val instanceof Matrix) {
            $this->validateEqualSizes($val);
        }

        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
                if (is_float($val)) {
                    $this->values[$i][$j] -= $val;
                } else {
                    $this->values[$i][$j] -= $val->getValue($i, $j);
                }
            }
        }

        return $this;
    }

    public function elementWiseProduct(Matrix $m) : Matrix
    {
        $this->validateEqualSizes($m);
       
        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
                $this->values[$i][$j] *= $m->getValue($i, $j)[0];
            }
        }

        return $this;
    }

    public function scalarMultiplication(float $f) : Matrix
    {
        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
                $this->values[$i][$j] *= $f;
            }
        }

        return $this;
    }

    public function dotProduct(Matrix $m)
    {
        $this->validateSizesForDotProduct($m);

        $w = 0;
        $result = [[]];

        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $m->getCols(); $j++) {
                for ($h = 0; $h < $this->getCols(); $h++) {
                    $w += $this->values[$i][$h] * $m->values[$h][$j];
                }
                $result[$i][$j] = $w;
                $w = 0;
            }
        }
        return new Matrix($result);
    }

    public function transpose() : Matrix
    {
        $values = [];
        for ($i = 0; $i < $this->getRows(); $i++) {
            for ($j = 0; $j < $this->getCols(); $j++) {
               $values[$j][$i] = $this->values[$i][$j];
            }
        }

        $this->values = [];
        $this->values = $values;

        $tempRows = $this->rows;
        $this->rows = $this->cols;
        $this->cols = $tempRows;

        return $this;
    }
}