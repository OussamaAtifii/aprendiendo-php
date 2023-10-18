<?php
function mostrarError(string $session)
{
    if (isset($_SESSION[$session])) {
        echo "<p class='text-red-600 text-sm italic'>{$_SESSION[$session]}</p>";
        unset($_SESSION[$session]);
    }
}

session_start();

$num = 47;

if (!isset($_SESSION['contador'])) {
    $_SESSION['contador'] = 0;
}

if (!isset($_SESSION['res'])) {
    $_SESSION['res'] = "";
}

if (isset($_POST["btnEnviar"])) {

    $errores = false;

    $numUsuario = (int) trim(htmlspecialchars($_POST["number"]));

    if ($numUsuario <= 0 || $numUsuario > 100) {
        $errores = true;
        $_SESSION["errNum"] = "El numero debe estar comprendido entre 1 y 100";
    }

    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    if ($numUsuario < $num) {
        $_SESSION["res"] = "El número es mayor";
        $_SESSION["contador"]++;
    } else if ($numUsuario > $num) {
        $_SESSION["res"] = "El número es menor";
        $_SESSION["contador"]++;
    } else {
        $_SESSION["res"] = "Felicidades, has adivinado el número";
        $_SESSION["contador"]++;
        $_SESSION["reset"] = true;
        // unset($_SESSION["res"]);
    }

    header("Location:{$_SERVER['PHP_SELF']}");
} else {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Tailwindcss -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- CDN Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Adivinar numero</title>
    </head>

    <body>
        <section class="bg-gray-50 dark:bg-gray-900">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            ADIVINA EL NUMERO
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div>
                                <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero</label>
                                <input <?php if (isset($_SESSION["reset"])) echo "readonly" ?> type="text" name="number" id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Numero elegido" required="">
                                <?php
                                mostrarError("errNum");
                                ?>
                            </div>
                            <div>
                                <!-- <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label> -->
                                <input readonly type="text" name="resultado" id="resultado" placeholder="<?php echo $_SESSION["contador"] != 0 ? $_SESSION["res"] . ". Intentos: " .  $_SESSION["contador"] : "" ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div class="flex gap-8">
                                <button type="submit" name="btnEnviar" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" <?php if (isset($_SESSION["reset"])) echo "disabled" ?>>Enviar</button>

                                <a href="reset.php" type="reset" name="btnReset" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>

<?php
}
?>