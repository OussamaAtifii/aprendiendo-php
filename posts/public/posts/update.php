<?php
session_start();

// Comprobar usuario este logeado
if (!isset($_SESSION['id'])) {
    header("HTTP/1.1 401 Unauthorized");
    require __DIR__ . "/../errors/401.html";
    die();
}

// Comprobar que este el id del post
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

$idUser = $_SESSION['id'];
$idPost = $_GET['id'];

use App\Db\Post;
use App\Utils\Utils;
use const App\Utils\MAY_ON;

require_once __DIR__ . "/../../vendor/autoload.php";

// Comprobar que el post si es del usuario logeado
$post = Post::getPostById($idPost, $idUser);

if (!$post) {
    header("HTTP/1.1 401 Unauthorized");
    require __DIR__ . "/../errors/401.html";
    die();
}

if (isset($_POST['btn'])) {
    $titulo = Utils::sanearTexto($_POST['titulo'], MAY_ON);
    $descripcion = Utils::sanearTexto($_POST['descripcion'], MAY_ON);

    $errores = false;
    if (!Utils::validarCadena("Titulo", $titulo, 3)) {
        $errores = true;
    }

    if (!Utils::validarCadena("Descripcion", $descripcion, 10)) {
        $errores = true;
    }

    // Imagen
    $imagen = $post->imagen;

    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        if (!Utils::validarImg($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $errores = true;
        } else {
            $ruta = "./../";
            $imagen = "img/posts/" . uniqid() . "_" . $_FILES['imagen']['name'];

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . $imagen)) {
                $_SESSION['Imagen'] = "No se puedo guardar la imagen";
            } else {
                // Borrar imagen anterior salvo que sea la imagen pode defecto
                if (basename($post->imagen) !== "default.jpg") {
                    unlink("./../" . $post->imagen);
                }
            }
        }
    }

    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}?id=$idPost");
        die();
    }

    (new Post)->setTitulo($titulo)
        ->setDescripcion($descripcion)
        ->setUser($idUser)
        ->setImagen($imagen)
        ->update($idPost);

    $_SESSION['mensaje'] = "Post creado correctamente";
    header("Location:index.php");
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
    <title>Update</title>
</head>

<body style="background-color:blanchedalmond">
    <div class="container p-8 mx-auto">
        <!------------------------------------------------------ NAVBAR -->
        <ul class='flex flex-row-reverse mt-2'>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='close.php'><i class='fa-solid fa-arrow-right-from-bracket'></i> Salir</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='index.php'><i class='fa-regular fa-newspaper'></i> Mis Posts</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href='../'><i class='fas fa-home'></i> Home</a>
            </li>
        </ul> <!----------------------------------------------------- FIN NAV BAR -->
        <h3 class="text-2xl text-center mt-4">Editar Post</h3>
        <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$idPost" ?>" enctype="multipart/form-data">
                <div class="mb-6">
                    <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título</label>
                    <input type="text" value="<?php echo $post->titulo ?>" name="titulo" id="nombre" placeholder="Título..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <?php Utils::mostrarErrores('Titulo') ?>
                </div>
                <div class="mb-6">
                    <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descripción</label>
                    <textarea name="descripcion" rows='5' id="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"><?php echo $post->descripcion ?></textarea>
                    <?php Utils::mostrarErrores('Descripcion') ?>
                </div>
                <div class="mb-6">
                    <div class="flex w-full">
                        <div class="w-1/2 mr-2">
                            <label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                IMAGEN</label>
                            <input type="file" id="imagen" oninput="img.src=window.URL.createObjectURL(this.files[0])" name="imagen" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                            <?php Utils::mostrarErrores('Imagen') ?>
                        </div>
                        <div class="w-1/2">
                            <img src="value=" <?php echo '../' . $post->imagen ?>" class="h-72 rounded w-full object-cover border-4 border-black" id="img">
                        </div>
                    </div>

                </div>

                <div class="flex flex-row-reverse">
                    <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <i class="fas fa-edit mr-2"></i>EDITAR
                    </button>
                    <button type="reset" class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                        <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
                    </button>
                    <a href="index.php" class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        <i class="fas fa-backward mr-2"></i>VOLVER
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>