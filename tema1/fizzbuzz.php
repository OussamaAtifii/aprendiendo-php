<?php

// 1º forma con if else
for ($i = 1; $i <= 100; $i++) {
    if ($i % 5 == 0 && $i % 7 == 0) {
        echo "fizz-buzz, ";
        continue;
    } else if ($i % 5 == 0) {
        echo "fizz, ";
    } else if ($i % 7 == 0) {
        echo "buzz, ";
    } else {
        echo "$i, ";
    }
}

// 2º forma con operador ternario
for ($i = 1; $i <= 100; $i++) {

    // Ternario sin anidar
    echo ($i % 35 == 0) ? "fizz-buzz, " : "$i, ";
    echo ($i % 5 == 0) ? "fizz, " : "";
    echo ($i % 7 == 0) ? "buzz, " : "";

    // Ternario anidado
    echo ($i % 5 == 0) ?
        (($i % 7 == 0) ? "fizz-buzz, " : "fizz, ") : (($i % 7 == 0) ? "buzz, " : "$i, ");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>