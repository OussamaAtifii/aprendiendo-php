<?php

function mostrarError(string $txt): void
{
    echo "<p style='color:red'>$txt</p>";
}

function isPrimo(int $num): bool
{
    if ($num == 1) return true;

    for ($i = 2; $i < $num; $i++) {
        if ($num % $i == 0) return false;
    }

    return true;
}

function pintarPrimos(int $cant): void
{
    for ($i = 0; $cant > 0; $i++) {
        if (isPrimo($i)) {
            echo "$i, ";
            $cant--;
        }
    }
}

if (isset($_GET["num"])) {
    $numero = (int) $_GET["num"];

    if ($numero <= 0) {
        mostrarError("El numero debe de ser positivo");
    } else {
        pintarPrimos($numero);
    }
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