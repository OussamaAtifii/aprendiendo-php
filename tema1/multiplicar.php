<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table border="2" cellpadding="5" cellspacing="5" align="center">
        <th colspan="5">TABLA DEL 5</th>
        <?php

        $numero = 10;
        for ($i = 1; $i <= 10; $i++) {

            echo "<tr>\n";
            echo "<td> $numero </td>";
            echo "<td> x </td>\n";
            echo "<td> $i </td>\n";
            echo "<td> = </td>\n";
            echo "<td>" . $i * $numero . "</td>\n";
            echo "</tr>\n";
        }
        ?>

    </table>
</body>

</html>