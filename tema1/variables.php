<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    echo "Hola mundo\n";
    echo "<br>Adios";
    echo 'Hola mundo con comillas simples';
    echo "<hr>";

    // Comentario de una linea

    /*
    * Comentario multilinea
    */

    $numero = 45;

    echo "El valor de la variable numero es $numero";
    echo "<br>";
    echo 'El valor de la variable numero es ' . $numero;


    $nombre = "23Oussama";
    $edad = 21;
    $sueldo = 3000.00;
    $isAdmin = true;

    echo "<br>";
    echo "\$nombre es de tipo: " . gettype($nombre);

    echo "<br>";
    echo "La suma es " . $nombre + $sueldo
    ?>

</body>

</html>