<?php
$user = "bydead30";

function cambiarUser(string $usuario)
{
    $user = $usuario;
    echo "Usuario en funcion = $user";
    echo "-------";
}

function cambiarUser1(string $user)
{
    $user = "cambiando valor";
    echo "Usuario en funcion = $user";
    echo "-------";
}

function cambiarUser2(string &$user)
{
    $user = "cambiando valor";
    echo "Usuario en funcion = $user";
    echo "-------";
}

function cambiarUser3(string &$user)
{
    global $user;
    $user = "cambiando valor";
    echo "Usuario en funcion = $user";
    echo "-------";
}

function cambiarValor(string $valor = "No se asigno ningun valor!!")
{
    return $valor;
}

function cambiarValor1(string &$variable, $valor = "No se asigno ningun valor!!")
{
    return $valor;
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

    <?php
    echo "<hr>";
    cambiarUser("PERICO");
    echo "Fuera de la funcion = $user";

    echo "<hr>";
    cambiarUser1($user);
    echo "Fuera de la funcion = $user";

    echo "<hr>";
    cambiarUser3($user);
    echo "Fuera de la funcion = $user";

    echo "<hr>";
    cambiarUser2($user);
    echo "Fuera de la funcion = $user";

    echo "<hr>";
    $nombre = "Oussama Atifi";
    $nombre = cambiarValor();
    echo $nombre;
    ?>


</body>

</html>