<?php
// $dia = "martes";
// switch ($dia) {
//     case 'martes':
//         echo "Hoy es martes";
//         break;
//     default:
//         echo "No es martes";
//         break;
// }

function frizzBuzz($num)
{
    echo match (0) {
        $num % 35 => "FrizzBuzz, ",
        $num % 5 => "Frizz, ",
        $num % 7 => "Buzz, ",
        default => "$num, "
    };
}

for ($i = 0; $i <= 100; $i++) {
    frizzBuzz($i);
}
