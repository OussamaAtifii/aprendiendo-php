<?php

session_start();

use App\Models\Producto;

require_once __DIR__ . "/../vendor/autoload.php";

$productos = Producto::read();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SWEETALERT -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Listado de productos</title>
</head>

<body>
    <h1 class="text-center text-2xl py-10 font-bold">PRODUCTOS</h1>
    <div class="flex flex-col mx-auto w-1/3">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="flex flex-row-reverse mb-1">
                    <a href="create.php" class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 ">
                        Añadir <i class="fa-solid fa-square-plus"></i>
                    </a>
                </div>
                <div class="border rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                            </tr>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            foreach ($productos as $producto) {
                                echo <<<TXT
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{$producto->nombre}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{$producto->precio}(€)</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="delete.php" method="POST">
                                        <input type="text" hidden name="id" value="{$producto->codigo}">
                                        <a href="update.php?id={$producto->codigo}" class="text-blue-500 hover:text-blue-700" title="modificar">
                                        <i class="fa-solid fa-square-pen"></i>
                                        </a>
                                        <button type="submit" class="text-blue-500 hover:text-blue-700" title="borrar">
                                            <i class="fa-solid fa-trash-can mr-2"></i>
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
        </div>
    </div>
    <?php
    if (isset($_SESSION["mensaje"])) {
        echo <<<TXT
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{$_SESSION["mensaje"]}',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
    TXT;
    }
    unset($_SESSION["mensaje"]);
    ?>
</body>

</html>