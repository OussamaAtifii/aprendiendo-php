<?php

if (!isset($_GET["id"])) {
    header("Location:index.php");
    die();
}

use Src\Models\Usuario;
use Src\Utils\{Errores, Provincias};

require_once __DIR__ . "/../vendor/autoload.php";

session_start();
$id = $_GET["id"];

$usuario = Usuario::findUser($id);
$checked = $usuario->perfil == "Admin" ? "checked" : "";
$provincias = Provincias::$misProvincias;

if (isset($_POST["btn"])) {
    $nombre = ucwords(htmlspecialchars(trim($_POST["nombre"])));
    $apellidos = ucwords(htmlspecialchars(trim($_POST["apellidos"])));
    $email = htmlspecialchars(trim($_POST["email"]));
    $provincia = $_POST["provincia"];
    $perfil = "User";

    if (isset($_POST["perfil"])) {
        $perfil = "Admin";
    }

    $errores = false;

    if (Errores::hayErrorCampo($nombre, 3)) {
        $errores = true;
        $_SESSION["errNombre"] = "Error, el nombre debe teber al menos 3 caracteres";
    }

    if (Errores::hayErrorCampo($apellidos, 6)) {
        $errores = true;
        $_SESSION["errApellidos"] = "Error, el apellido debe tener al menos 6 caracteres";
    }

    if (Errores::emailValido($email, $id)) {
        $errores = true;
        $_SESSION["errEmail"] = "Error, el email es invalido o está duplicado";
    }

    if (!Errores::errorProvincia($provincia)) {
        $errrores = true;
        $_SESSION["errProvincia"] = "Error, la provincia no es válida";
    }

    // ! Añadir id ya que en el update necesita un id, no como en el form
    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        die();
    }

    (new Usuario)->setNombre($nombre)
        ->setApellidos($apellidos)
        ->setPerfil($perfil)
        ->setEmail($email)
        ->setProvincia($provincia)
        ->update($id);

    $_SESSION["mensaje"] = "Usuario actualizado con éxito";
    header("Location:index.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Tailwind css -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Sweetalert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Crear</title>
    </head>

    <body style="background-color:blanchedalmond">
        <h3 class="text-2xl text-center mt-4">Nuevo Usuario</h3>
        <div class="container p-8 mx-auto">
            <div class="w-1/2 mx-auto p-6 rounded-xl bg-gray-400">
                <!--  // ! Añadir id ya que en el update necesita un id, no como en el form -->
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id" ?>">
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu Nombre</label>
                        <input type="text" name="nombre" value="<?php echo $usuario->nombre; ?>" id="nombre" placeholder="Nombre..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php
                        Errores::pintarError("errNombre")
                        ?>
                    </div>
                    <div class="mb-6">
                        <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tus
                            Apellidos</label>
                        <input type="text" name="apellidos" value="<?php echo $usuario->apellidos; ?>" id="apellidos" placeholder="Apellidos..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php
                        Errores::pintarError("errApellidos")
                        ?>

                    </div>
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu
                            email</label>
                        <input type="email" id="email" name="email" value="<?php echo $usuario->email; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com">
                        <?php
                        Errores::pintarError("errEmail")
                        ?>

                    </div>
                    <div class="mb-6">
                        <label for="provincia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu
                            Provincia</label>
                        <select name="provincia" id="provincia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value='-1'>____ Elige una Provincia ____</option>
                            <?php
                            foreach ($provincias as $provincia) {
                                $selected = $usuario->provincia == $provincia ? "selected" : "";
                                echo "<option $selected>$provincia</option>";
                            }
                            ?>
                        </select>
                        <?php
                        Errores::pintarError("errProvincia")
                        ?>
                    </div>
                    <div class="mb-4">
                        <label class="relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" value="Admin" <?php echo $checked ?> class="sr-only peer" name="perfil">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Soy Administrador</span>
                        </label>
                    </div>
                    <div class="flex flex-row-reverse">
                        <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fas fa-edit mr-2"></i>EDITAR
                        </button>
                        <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                            <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                        </button>
                        <a href="inicio.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                            <i class="fas fa-backward mr-2"></i>VOLVER
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </body>

    </html>


<?php
}
?>