<?php

function mostrarError(string $txt): void
{
    echo "<p style='color:red'>$txt</p>";
}

function tabla(int $fila, int $columna): void
{
    echo "<table>";

    for ($i = 0; $i < $fila; $i++) {
        $color = "#" . random_int(100000, 999999);

        echo "<tr style='background-color:$color'>";
        for ($j = 0; $j < $columna; $j++) {
            echo "<td>[$i][$j]</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

if (isset($_GET["fil"]) && isset($_GET["col"])) {
    $fila = $_GET["fil"];
    $columna = $_GET["col"];

    if ($fila <= 0 || $columna <= 0) {
        mostrarError("La columna y/o la fila no pueden ser negativas o iguales a 0.");
    } else {
        tabla($fila, $columna);
    }
} else {
    mostrarError("No hay columnas y/o filas");
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