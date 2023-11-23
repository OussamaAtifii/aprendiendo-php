<?php
session_start();

use App\Db\Autores;
use App\Db\Libros;

require_once __DIR__ . "/../vendor/autoload.php";

Autores::generarAutores(10);
Libros::generarLibros(50);
$libros = Libros::read();
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

<body>
    <h3 class="my-2 text-xl text-center">LIBRERIA</h3>

    <!-- TABLE -->
    <div class="mb-1 flex justify-end w-2/4 mx-auto">
        <a href="nuevo.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-add mr-1"></i>
            Add
        </a>
    </div>
    <div class="relative mx-auto w-2/4  shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Info
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Author
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($libros as $libro) {
                    echo <<<TXT
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="detalle.php?idLibro={$libro->id}"><i class="fas fa-info text-blue-500"></i></a>
                        </th>
                        <td class="px-6 py-4">
                            {$libro->titulo}
                        </td>
                        <td class="px-6 py-4">
                        {$libro->apellidos}, {$libro->nombre}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="borrar.php" method="POST">
                                <a href="update.php?id={$libro->id}">
                                    <i class="fas fa-edit text-green-500 mr-1"></i>
                                </a>
                                <input type="hidden" name="idLibro" value="$libro->id">
                                <button>
                                    <i class="fas fa-trash text-red-600"></i>
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


    <!-- END TABLE -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
        <script>
        Swal.fire({
            icon: "success",
            title: "{$_SESSION['mensaje']}",
            showConfirmButton: false,
            timer: 900
          });
        </script>
        TXT;
    }

    unset($_SESSION['mensaje']);
    ?>
</body>

</html>