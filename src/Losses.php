<?php

use App\Math\Matrix;

function mse($yTrue, $yPred)
{
    // $sum = 0;
    // for ($i = 0; $i < count($yTrue); $i++) {
    //     $sum += ($yTrue - $yPred)**2;
    // }
   
    return (($yTrue - $yPred)**2)/2;
}

function msePrime($yTrue, $yPred)
{
    // $values = [];
    // for ($i = 0; $i < count($yTrue); $i++) {
    //     $values[$i] = 2 * ($yPred[$i] - $yTrue[$i]) / count($yTrue);
    // }

    return new Matrix([[
        2 * ($yPred - $yTrue)
    ]]);
}