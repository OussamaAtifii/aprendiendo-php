<?php
function showErrors(string $session_name)
{
    if (isset($_SESSION[$session_name])) {
        echo "<p class='text-red-600 text-sm italic pt-1'>" . $_SESSION[$session_name] . "</p>";
        unset($_SESSION[$session_name]);
    }
}

session_start();

if (isset($_POST["btnSign"])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $pass = htmlspecialchars(trim($_POST["password"]));
    $errors = false;

    if (strlen($username) < 3) {
        $errors = true;
        $_SESSION["errUsername"] = "Usuario invalido";
    }

    if (strlen($pass) < 3) {
        $errors = true;
        $_SESSION["errPass"] = "Contraseña debe tener 3 o más caracteres";
    }

    if ($errors) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    require "./users.php";

    foreach ($users as $user) {
        if ($user[0] == $username && $user[1] == $pass) {
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $pass;
            $_SESSION["rol"] = $user[2];
            header("Location:portal.php");
            die();
        }
    }

    $_SESSION["errSign"] = "Usuario y/o contraseña incorrectos";

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
        <title>Formulario</title>
    </head>

    <body class="flex justify-center items-center h-screen">
        <form class="w-full max-w-sm" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="md:flex md:items-start flex-col mb-4">
                <label class="block text-gray-600 font-bold md:text-right mb-1 md:mb-0" for="username">
                    Username
                </label>
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 shadow-lg" id="username" name="username" type="text" placeholder="example@example.com">
                <?php showErrors("errUsername") ?>
            </div>
            <div class="md:flex md:items-start flex-col mb-4">
                <label class="block text-gray-600 font-bold md:text-right mb-1 md:mb-0" for="password">
                    Password
                </label>
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 shadow-lg" id="password" name="password" type="password" placeholder="******************">
                <?php showErrors("errPass") ?>
            </div>
            <button name="btnSign" type="submit" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                Sign Up
            </button>
            <?php showErrors("errSign") ?>
        </form>
    </body>

    </html>

<?php
}
?>