<?php
// // $provAnd = ["Cadiz", "Almeria", "Cordoba", "Granada", "Huelva", "Jaen", "Malaga", "Sevilla"];
// $provAnd = [3, 2, 3432, 6, 7, 8, 90, 76, 342];
// $provExt = ["Cáceres", "Badajoz"];
// $provVal = ["Alicante", "Castellón", "Valencia"];


// $total = [
//     "Andalucia" => $provAnd,
//     "Extremadura" => $provExt,
//     "Valencia" => $provVal
// ];


// // Desordenar arrrays
// // shuffle($provAnd);
// // echo $provAnd[0];

// // Ordenar arrrays sort(A-Z), rsort(Z-A)
// print_r($provAnd);
// echo "<br>";
// sort($provAnd);
// echo "<br>";
// print_r($provAnd);


// $datos = [
//     "uno" => "Primer dato",
//     "dos" => "Segundo dato",
//     "tres" => "Tercer dato",
// ];

// echo "<br>";

// // explode, implode, compact, in_array()

// //Compact

// $nombre = "Oussama";
// $email = "oussamaati03@gmail.com";


$comunidades = [
    "Madrid" => ["Madrid"],
    "Extremadura" => ["Caceres", "Badajoz"],
    "Andalucia" => ["Sevilla", "Granada", "Almeria"],
    "Galicia" => ["La Coruña", "Orense", "Lugo", "Pontevedra"],
];

ksort($comunidades);
foreach ($comunidades as $k => $v) {
    sort($comunidades[$k]);
}
print_r($comunidades);
