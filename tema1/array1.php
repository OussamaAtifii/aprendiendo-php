<?php

function pintarTabla(array $total): void
{
    foreach ($total as $k => $v) {
        echo "<table border='2' align='center'>\n";
        echo "<tr>\n";
        echo "<th align = 'center' colspan='" . count($v) . "'>$k</th>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        foreach ($v as $comunidad) {
            echo "<td>$comunidad</td>\n";
        }
        echo "</tr>\n";

        echo "</table>\n";
        echo "<br>";
    }
}

// $prov = ["Almeria", "Cordoba"];
// $prov1 = array("Almeria", "Cordoba");


// $prov[] = "Cadiz";
// $prov[1] = "Cadiz";



// var_dump($prov);

// foreach ($prov as $k => $v) {
//     echo "<br>$k ---- $v.";
// }

$provAnd = ["Almeria", "Cadiz", "Cordoba", "Granada", "Huelva", "Jaen", "Malaga", "Sevilla"];
$provExt = ["Cáceres", "Badajoz"];
$provVal = ["Alicante", "Castellón", "Valencia"];


$total = [
    "Andalucia" => $provAnd,
    "Extremadura" => $provExt,
    "Valencia" => $provVal
];

pintarTabla($total);


// echo "<ul>";
// foreach ($total as $k => $v) {
//     echo "<li> $k </li>";
//     foreach ($v as $comunidad) {
//         echo "<ul>";
//         echo "<li> $comunidad </li>";
//         echo "</ul>";
//     }
// }
// echo "</ul>";
