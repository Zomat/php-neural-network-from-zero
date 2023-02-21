<?php

declare(strict_types=1);

namespace App\Layers;

use App\Actions\Matrix\CreateMatrixWithRandAction;
use App\Math\Matrix;
use App\Interfaces\LayerInterface;

class Dense implements LayerInterface
{
    public Matrix $input;

    public Matrix $weights;

    public Matrix $bias;

    public function __construct(int $inputSize, int $outputSize)
    {
        $createMatrixAction = new CreateMatrixWithRandAction;
        $this->weights = $createMatrixAction->handle($outputSize, $inputSize);
        $this->bias = $createMatrixAction->handle($outputSize, 1);
    }

    public function forward(Matrix $input) : Matrix
    {
        $this->input = $input;
        return $this->weights->dotProduct($input)->add($this->bias);
    }

    public function backward(Matrix $outputGradient, float $learningRate) : Matrix
    {
        $input = $this->input;
        $weights = $this->weights;

        $weightsGradient = $outputGradient->dotProduct($input->transpose());
        $inputGradient = ($weights->transpose())->dotProduct($outputGradient);

        $this->weights->transpose()->sub($weightsGradient->scalarMultiplication($learningRate));
        $this->bias->sub($outputGradient->scalarMultiplication($learningRate));

        return $inputGradient;
    }
}