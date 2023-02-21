<?php

namespace App\Layers;

use App\Math\Matrix;
use App\Interfaces\LayerInterface;

class Tanh implements LayerInterface
{
    public Matrix $input;

    public function forward(Matrix $input) : Matrix
    {
        $this->input = $input;
        
        $values = [];
        for ($i = 0; $i < $input->getRows(); $i++) {
            for ($j = 0; $j < $input->getCols(); $j++) {
                $values[$i][$j] = $this->activation($input->getValue($i, $j));
            }
        }

        return new Matrix($values);
    }
    
    public function backward(Matrix $outputGradient, float $learningRate) : Matrix
    {
        $input = $this->input;

        $values = [];
        for ($i = 0; $i < $input->getRows(); $i++) {
            for ($j = 0; $j < $input->getCols(); $j++) {
                $values[$i][$j] = $this->activationPrime($input->getValue($i, $j));
            }
        }
       
        return $outputGradient->elementWiseProduct((new Matrix([$values]))->transpose());
    }

    protected function activation(float $x)
    {
        return tanh($x);
    }

    protected function activationPrime(float $x)
    {
        return (1 - tanh($x)**2);
    }
}