<?php

use App\Db\Articulos;

if (!isset($_GET['id'])) {
    header("Location:index.php");
}

require_once __DIR__ . "/../vendor/autoload.php";

$articulo = Articulos::findArticle($_GET['id']);

if (!$articulo) {
    header("Location:index.php");
    die();
}

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
    <h1 class="text-center text-xl mt-5 p-5">Detalle de Articulos</h1>

    <div class="mx-auto w-2/3">
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-auto">
            <img class="rounded-t-lg" src="<?php echo "./{$articulo->imagen}" ?>" alt="" />
            <div class="p-5">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $articulo->nombre ?></h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> <?php echo $articulo->descripcion ?></span></p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Precio: <span class="font-bold"> <?php echo $articulo->precio ?> (€)</span></p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Stock: <span class="font-bold"><?php echo $articulo->stock ?> </span></p>
                <a href="" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fas fa-home mr-2"></i> Inicio
                </a>
            </div>
        </div>
    </div>
</body>

</html>