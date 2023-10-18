<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="2" cellpadding="5" cellspacing="5" align="center">
        <?php
        $fila = 8;
        $columna = 8;

        for ($i = 0; $i < $fila; $i++) {
            echo "<tr>\n";
            for ($j = 0; $j < $columna; $j++) {
                if (($j + $i) % 2 == 0) {
                    echo "<td style = 'background-color:white'; color:black>B</td>\n";
                } else {
                    echo "<td style = 'background-color:black'; color:white>N</td>\n";
                }
            }
            echo "</tr>\n";
        }
        ?>
    </table>

    <?php
    $num = 19;
    $contador = 0;

    for ($i = 2; $i < $num; $i++) {
        if ($num % $i == 0) {
            $contador++;
            break;
        }
    }

    if ($contador != 0) {
        echo "No es primo";
    } else {
        echo "Si es primo";
    }

    echo "<br>";
    echo "Hay $contador divisores";
    ?>
</body>

</html>