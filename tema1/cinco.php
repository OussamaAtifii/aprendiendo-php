<?php

function pintarTabla(int $fila, int $columna): void
{
    echo "<table border='2' align='center'>";

    for ($i = 0; $i < $fila; $i++) {
        echo "<tr>\n";
        for ($j = 0; $j < $columna; $j++) {
            echo "<td>$i - $j</td>\n";
        }
        echo "</tr>\n";
    }

    echo "</table>";
}

function mostrarError(string $txt): void
{
    echo "<p style='color:red'>$txt</p>";
}

//1.- Ver si url contiene parámetros (fil, col)

if (isset($_GET["fil"]) && isset($_GET["col"])) {
    $f = (int) $_GET["fil"];
    $c = (int) $_GET["col"];

    if ($f <= 0 || $c <= 0) {
        mostrarError("Las filas y/o columnas no pueden ser negativas o iguales a 0");
    } else {
        pintarTabla($f, $c);
    }
} else {
    mostrarError("Falta la columna y/o la fila");
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