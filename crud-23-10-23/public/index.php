<?php

session_start();

use Src\Models\Usuario;

require_once __DIR__ . "/../vendor/autoload.php";

Usuario::crearRegistrosAleatorios(120);
$todos = Usuario::read();

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
    <title>Document</title>
</head>

<body>
    <h1 class="text-center text-xl mt-5">Listado de Usuarios</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-2/3 m-5 mx-auto">
        <div class="flex flex-row-reverse mb-3">
            <a href="./form.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add mr-2"></i>Nuevo</a>

        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Apellido
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Provincia
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Perfil
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($todos as $usuario) {
                    $colorPerfil = $usuario->perfil == "Admin" ? "text-red-500" : "text-green-500";

                    echo <<<TXT
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {$usuario->nombre}
                    </th>
                    <td class="px-6 py-4">
                        {$usuario->apellidos}
                    </td>
                    <td class="px-6 py-4">
                        {$usuario->email}
                    </td>
                    <td class="px-6 py-4">
                        {$usuario->provincia}
                    </td>
                    <td class="$colorPerfil px-6 py-4">
                        {$usuario->perfil}
                    </td>
                    <td class="px-6 py-4">
                        <form action="delete.php" method="POST">
                            <input name="id" hidden value="{$usuario->id}">
                            <button type="submit">
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