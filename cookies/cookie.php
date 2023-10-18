<?php
if (isset($_POST["btnEnviar"])) {
    setcookie("contador", "", time() - 1);
    header("Location:cookie.php");
    die();
}

if (isset($_COOKIE["contador"])) {
    setcookie("contador", $_COOKIE["contador"] + 1, time() + 7 * 24 * 60 * 60);
    $mensaje = "Has visitado " . $_COOKIE["contador"] . " veces";
    // echo date("d/m/Y");
} else {
    $mensaje = "Hoy es la primera vez";
    setcookie("contador", 1, time() + 7 * 24 * 60 * 60);
}

if (!isset($_COOKIE['fecha'])) {
    $mensajeFecha = "<br>Es la primera vez que visitas nuestro fantástico Portal";
    setcookie('fecha', date("m-d-Y, H:i:s"), time() + 7 * 24 * 60 * 60);
} else {
    $mensajeFecha = "<br>Visitaste nuestro sitio por última vez: <b>" . $_COOKIE['fecha'] . "</b>";
    setcookie('fecha', date("m-d-Y, H:i:s"), time() + 7 * 24 * 60 * 60);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>PORTAL</title>
</head>

<body>
    <?php
    echo $mensaje;
    ?>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <button name="btnEnviar" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            REINICIAR
        </button>

    </form>

    <?php
    echo $mensajeFecha;
    ?>
</body>

</html>