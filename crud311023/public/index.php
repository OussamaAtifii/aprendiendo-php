<?php
session_start();

use App\Db\Articulos;

require_once __DIR__ . "/../vendor/autoload.php";

Articulos::registrosRandom(5);
$articulos = Articulos::read();
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
    <h1 class="text-center text-xl mt-5 p-5">Listado de Articulos</h1>

    <div class="mx-auto w-2/3">
        <div class="flex flex-row-reverse mb-2">
            <a href="./crear.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add mr-2"></i> Nuevo
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Precio (€)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articulos as $articulo) {
                        $color = $articulo->stock <= 5 ? "text-red-600" : "text-green-600";
                        echo <<<TXT
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-32 p-4">
                            <img src="./{$articulo->imagen}" alt="{$articulo->nombre}">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {$articulo->nombre}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {$articulo->descripcion}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                            {$articulo->precio}(€)
                        </td>
                        <td class="px-6 py-4 font-semibold $color">
                            {$articulo->stock}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="delete.php" method="POST">
                            <input type="hidden" name="id" value="{$producto->id}" />
                            <a href="detalles.php?id={$articulo->id}">
                                <i class="fas fa-info mr-5"></i>
                            </a>
                            <a href="update.php?id={$articulo->id}">
                                <i class="fas fa-edit mr-5"></i>
                            </a>
                            <button type="submit">
                                <i class="fas fa-trash"></i>
                            </button>
                            </form>
                        </td>
                    </tr>
                    TXT;
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{$_SESSION['mensaje']}',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        TXT;
        unset($_SESSION['mensaje']);
    }
    ?>
</body>

</html>