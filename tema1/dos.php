<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    $numero1 = 123;
    $numero2 = 123;

    if ($numero1 > $numero2) {
        echo "$numero1 es mayor que $numero2";
    } else if ($numero2 > $numero1) {
        echo "$numero2 es mayor que $numero1";
    } else {
        echo "$numero2 es igual a $numero1";
    }

    for ($i = 0; $i < 10; $i++) {
    }

    $a = 0;
    do {
        echo $a++;
        echo "<br>";
    } while ($a < 10);

    ?>


</body>

</html>