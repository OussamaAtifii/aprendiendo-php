<?php

use App\Db\Articulos;
use App\Utils\Errores;

use const App\Utils\MAYUS_ON;

session_start();

require_once __DIR__ . "/../vendor/autoload.php";

if (isset($_POST['btn'])) {
    $nombre = Errores::sanearCampos($_POST['nombre'], MAYUS_ON);
    $descripcion = Errores::sanearCampos($_POST['descripcion'], MAYUS_ON);
    $precio = (float) (trim($_POST['precio']));
    $stock = (int) (trim($_POST['stock']));

    $errores = false;


    if (Errores::errorTexto("Nombre", $nombre, 3)) {
        $errores = true;
    }

    if (Errores::errorTexto("Descripcion", $descripcion, 5)) {
        $errores = true;
    }

    if (Errores::errorNum("Precio", $precio, 5, 10000)) {
        $errores = true;
    }

    if (Errores::errorNum("Stock", $stock, 1, 100)) {
        $errores = true;
    }

    // PROCESO DE IMAGEN
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        if (Errores::errorImagen($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $errores = true;
        } else {
            $rutaImagen = "./img/" . uniqid() . "_" . $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
            $imagen = substr($rutaImagen, 2);
        }
    } else {
        $imagen = "img/default.png";
    }

    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }

    (new Articulos)->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->setPrecio($precio)
        ->setStock($stock)
        ->setImagen($imagen)
        ->create();

    $_SESSION['mensaje'] = "El artiuclo a sido añadido correctamente";
    header("Location:index.php");
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <!-- TAILWIND -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- FONTAWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- SWEETALERT -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Articulos</title>
    </head>

    <body>
        <h1 class="text-center text-xl mt-5 p-5">Crear Articulo</h1>

        <div class="mx-auto w-2/3">
            <div class="w-3/4 mx-auto p-6 rounded-xl bg-gray-400">
                <!-- // ! Hay que añadir enctype cuando hay que subir imagenes -->
                <form method="POST" action="crear.php" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <?php Errores::mostrarErrores("Nombre") ?>
                    </div>
                    <div class="mb-6">
                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Descripción</label>
                        <textarea name="descripcion" rows='5' id="desc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        <?php Errores::mostrarErrores("Descripcion") ?>

                    </div>
                    <div class="mb-6">
                        <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Precio (€)</label>
                        <input type="number" id="precio" name="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" step="0.01" max="9999,99" min="0">
                        <?php Errores::mostrarErrores("Precio") ?>

                    </div>
                    <div class="mb-6">
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Stock</label>
                        <input type="number" id="stock" name="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" step="1" min="0" />
                        <?php Errores::mostrarErrores("Stock") ?>
                    </div>
                    <div class="mb-6">
                        <div class="flex w-full">
                            <div class="w-1/2 mr-2">
                                <label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    IMAGEN</label>
                                <input type="file" id="imagen" oninput="img.src=window.URL.createObjectURL(this.files[0])" name="imagen" accept="image/*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                <?php Errores::mostrarErrores("Imagen") ?>
                            </div>
                            <div class="w-1/2">
                                <img src="./img/noimage.png" class="h-72 rounded w-full object-cover border-4 border-black" id="img">
                            </div>
                        </div>


                    </div>

                    <div class="flex flex-row-reverse">
                        <button type="submit" name="btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fas fa-save mr-2"></i>GUARDAR
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