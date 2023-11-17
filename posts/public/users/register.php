<?php

use App\Db\User;
use App\Utils\Utils;

require_once __DIR__ . "/../../vendor/autoload.php";
session_start();

if (isset($_SESSION['Email'])) {
    header("Location:./../posts");
    die();
}

if (isset($_POST['btn'])) {
    $email = Utils::sanearTexto($_POST['email']);
    $password = Utils::sanearTexto($_POST['password']);
    $errors = false;

    if (!Utils::validarEmail($email)) {
        $errors = true;
    } else {
        if (User::existeEmail($email)) {
            $errors = true;
            $_SESSION['email'] = "Ya existe un usuario con ese email";
        }
    }

    if (!Utils::validarCadena("password", $password, 5)) {
        $errors = true;
    }

    // Procesar imagen
    $foto = "img/perfil/default.png";
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
        if (Utils::validarImg($_FILES['foto']['type'], $_FILES['foto']['size'])) {
            $ruta = "./../";
            $foto = "img/perfil/." . uniqid() . "_" . $_FILES['foto']['name'];

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $ruta . $foto)) {
                $errors = true;
                $_SESSION['Imagen'] = "No se pudo guardar la imagen";
            }
        } else {
            $errors = true;
        }
    }

    if ($errors) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    (new User)->setEmail($email)
        ->setPassword($password)
        ->setFoto($foto)
        ->setIsAdmin(0)
        ->create();

    $id = User::getIds($email)[0]->id;

    $_SESSION['Email'] = $email;
    $_SESSION['id'] = $id;
    $_SESSION['perfil'] = 0;

    // User::login($email, $password);

    header("Location:./../posts/index.php");
    die();
}


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
    <title>Document</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="text-2xl text-center mt-4">Registro</h3>
    <!-- Formulario login -->
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mt-4">
        <div class="w-full bg-white rounded-xl shadow-xl dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Crea una cuenta
                </h1>
                <form class="space-y-4 md:space-y-6" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                        <?php echo Utils::mostrarErrores('email') ?>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                    </div>
                    <div>
                        <label for="foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto de perfil</label>
                        <input type="file" name="foto" id="foto" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg 
                    focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                     dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" accept="image/*">

                    </div>
                    <button type="submit" name="btn" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl"><i class="fas fa-save mr-2"></i>Register</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Ya regesitrado? <a href="../login.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Log In</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN FORMULARIO -->
</body>

</html>