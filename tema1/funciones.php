<?php
function isPrimo(int $num): bool
{
    if ($num == 1) return true;

    for ($i = 2; $i < $num; $i++) {
        if ($num % $i == 0) return false;
    }

    return true;
}

function pintarTabla(int $fila, int $columna, string $texto = "Sin mensaje"): void
{
    echo "<table border='2' align='center'>";

    for ($i = 0; $i < $fila; $i++) {
        echo "<tr>\n";
        for ($j = 0; $j < $columna; $j++) {
            echo "<td> $texto </td>\n";
        }
        echo "</tr>\n";
    }

    echo "</table>";
}

// function tipoFruta(string $nombre, string $tipo = "Sin definir"): void
// {
//     echo "El nombre es: $nombre y el tipo $tipo";
//     echo "<br>";
// }

// Lo de abajo esta mal ya que hay que definir los parámetros con valores por defecto al final de una función

function tipoFruta(string $tipo = "Sin definir", string $nombre): void
{
    echo "El nombre es: $nombre y el tipo $tipo";
    echo "<br>";
}

function pintarDatos($nombre, $apellido, $cargo = "Sin cargo", $ciudad = "Sin especificar")
{
    echo "El nombre es $nombre, apellidos = $apellido";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    // $numero = 30;
    // $contador = 0;

    // for ($i = 0; $i < $numero; $i++) {
    //     if (isPrimo($i)) {
    //         echo "$i, ";
    //         $contador++;
    //     }
    // }
    // echo "Hay " . $contador . " números primos.";

    // $cantidad = 5;

    // for ($i = 1; $cantidad > 0; $i++) {
    //     if (isPrimo($i)) {
    //         echo $i;
    //         $cantidad--;
    //     }
    // }

    // $num1 = 1;
    // $num2 = 5;

    // for ($i = min($num1, $num2); $i <= max($num1, $num2); $i++) {
    //     if (isPrimo($i)) {
    //         echo "$i, ";
    //     }
    // }
    // pintarTabla(fila: 10, columna: 10, texto: "SI");

    tipoFruta("Cítrico", "Limón");

    ?>
</head>

<body>

</body>

</html>