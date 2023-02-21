<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Losses.php';

use App\Network;
use App\Layers\Tanh;
use App\Math\Matrix;
use App\Layers\Dense;

/**
 * PHP Neural Network from complete scratch.
 * Author: Mateusz Zolisz
 * Example for XOR.
 */

$trainingSet = [
    [0, 0],
    [0, 1],
    [1, 0],
    [1, 1],
];

$resultSet =  [0, 1, 1, 0];

$network = new Network([
    new Dense(2, 3),
    new Tanh(),
    new Dense(3, 1),
    new Tanh()
]);

$network->train(1000, $trainingSet, $resultSet, 0.1, true);

$out = $network->predict(new Matrix([
    [0],
    [0]
]));

echo round($out->getValue(0, 0), 0) . PHP_EOL;