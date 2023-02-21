<?php

namespace App;

use App\Math\Matrix;
use App\Interfaces\LayerInterface;

class Network
{
    public array $layers;

    public function __construct(array $layers)
    {
        $this->layers = $layers;
    }
    
    public function predict(Matrix $input) : Matrix
    {
        $output = $input;
        foreach ($this->layers as $layer) {
            $output = $layer->forward($output);
        }

        return $output;
    }

    public function train(int $epochs, array $trainingSet, array $resultSet, float $learningRate, bool $verbose = true)
    {
        for ($i = 0; $i < $epochs; $i++) {
            $error = 0;
        
            for ($j = 0; $j < count($trainingSet); $j++) {
                $output = $this->predict(new Matrix([
                    [$trainingSet[$j][0]],
                    [$trainingSet[$j][1]]
                ]));
                
                $error += mse($resultSet[$j], $output->getValue(0, 0));
               
                $grad = msePrime($resultSet[$j], $output->getValue(0, 0));
        
                foreach (array_reverse($this->layers, true) as $layer) {
                    $grad = $layer->backward($grad, $learningRate);
                }
               
            }
            $error /= count($trainingSet);
        
            if ($verbose) {
                echo round($error, 8) . "\n";
            }
        }
    }
}