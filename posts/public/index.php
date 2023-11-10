<?php

use App\Db\Post;
use App\Db\User;

require_once __DIR__ . "/../vendor/autoload.php";

User::generarUsuarios(10);
Post::generarPosts(50);
$posts = Post::readAll();
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
    <nav>
        <ul class="flex mt-4 w-3/4 mx-auto flex-row-reverse">
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="./users/register.php">Register</a>
            </li>
            <li class="mr-6">
                <a class="text-blue-500 hover:text-blue-800" href="./login.php">Login</a>
            </li>
        </ul>
    </nav>

    <h3 class="text-xl text-center my-2">POSTS AL-ANDALUS</h3>
    <div class="grid grid-cols-3 gap-4 mx-auto w-3/4">
        <?php
        foreach ($posts as $post) {
            echo <<<TXT
            <a href="./posts/detalles.php?id=$post->id">
                <article class="h-80 w-full" style="background-image:url('./{$post->imagen}')">
                    <div class="flex flex-col justify-around h-full text-neutral-400">
                        <div class="text-center w-full text-2xl font-semibold">{$post->titulo}</div>
                        <div class="w-full text-center italic text-lg">{$post->email}</div>
                    </div>
                </article>
            </a>
            TXT;
        }
        ?>
    </div>
</body>

</html>