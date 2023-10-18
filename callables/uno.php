<?php

// $suma = function (int|float $a, int|float $b) {
//     return $a + $b;
// };

// echo $suma(10, 20);

// $suma1 = fn ($a, $b) => $a + $b;

$array1 = range(1, 50);

function buscarPares(array $prueba): array
{
    $pares = [];
    foreach ($prueba as $v) {
        if ($v % 2 == 0) $pares[] = $v;
    }
    return $pares;
}

var_dump(buscarPares($array1));

function buscarMultiTres(array $prueba): array
{
    $multiplos = [];
    foreach ($prueba as $v) {
        if ($v % 3 == 0) $multiplos3[] = $v;
    }
    return $multiplos3;
}

echo "<br>";
var_dump(buscarMultiTres($array1));


$pares = fn ($num) => ($num % 2 == 0) ? true : false;

$multiTres = function (int $num) {
    return ($num % 3 == 0) ? true : false;
};

function filtrarArry(array $datos, callable $filtro): array
{
    $devolver = [];
    foreach ($datos as $v) {
        if ($filtro($v)) $devolver[] = $v;
    }

    return $devolver;
}

var_dump(filtrarArry($array1, $pares));
var_dump(filtrarArry($array1, $multiTres));

$arrayMultSiete = filtrarArry($array1, fn ($num) => ($num % 7 == 0) ? true : false);
var_dump($arrayMultSiete);
