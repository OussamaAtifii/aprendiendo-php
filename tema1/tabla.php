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
        $fila = 10;
        $columna = 10;

        for ($i = 0; $i < $fila; $i++) {
            echo "<tr>\n";
            for ($j = 0; $j < $columna; $j++) {
                echo "<td>celda $i - $j</td>\n";
            }
            echo "</tr>\n";
        }
        ?>

    </table>
</body>

</html>