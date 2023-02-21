<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Math\Matrix;

interface LayerInterface
{
    public function forward(Matrix $input);
    
    public function backward(Matrix $outputGradient, float $learningRate) : Matrix;
}
