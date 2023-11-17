<?php

use App\Db\Post;

require_once __DIR__ . "/../../vendor/autoload.php";

session_start();
if (!isset($_SESSION['Email'])) {
    header("Location:../index.php");
    die();
}
$id = $_SESSION['id'];
$email = $_SESSION['Email'];

// Solo devolvera los posts del usuario logeado
// die(var_dump($id));
$posts = Post::readAll($id);

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
    <!-- NAV BAR -->
    <nav>
        <ul class="flex mt-4 w-3/4 mx-auto flex-row-reverse">
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="./logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="../index.php"><i class="fas fa-home"></i> Home</a>
            </li>
        </ul>
    </nav>

    <!-- HEADER -->
    <h3 class="text-xl text-center my-2">Posts de <?php echo $email ?></h3>

    <!-- TABLA POSTS -->

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-1/2 mx-auto mt-10">
        <div class="mx-auto mt-10 flex flex-row-reverse mb-2">
            <a href="nuevo.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add"></i> New post
            </a>
        </div>
        <?php
        if ($posts) {

        ?>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Titulo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Accion
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($posts as $post) {
                        echo <<<TXT
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-32 p-4">
                        <img src="./../{$post->imagen}" alt="{$post->titulo}">
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {$post->titulo}
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {$post->descripcion}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="borrar.php" method="POST">
                            <input type="hidden" name="id" id="id" value="{$post->id}">
                            <a href="detalles.php?id={$post->id}">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <a href="update.php?id={$post->id}">
                                <i class="fas fa-edit mx-2"></i></a>
                            <button type="submit" class="font-medium text-red-600">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                TXT;
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p class='`x-4 py-3 rounded-xl shadow-xl border-2 border-blue-600 text-white bg-black'> Aún no ha creado ningun post, aprovecha para crear el primero</p>";
        }
        ?>
    </div>

    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
        <script>
        Swal.fire({
            icon: "success",
            title: "{$_SESSION['mensaje']}",
            showConfirmButton: false,
            timer: 1500
          });
        </script>
        TXT;
    }

    unset($_SESSION['mensaje']);
    ?>
</body>

</html>