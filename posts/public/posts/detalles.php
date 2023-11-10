<?php

use App\Db\Post;

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

$id = $_GET['id'];

require_once __DIR__ . "/../../vendor/autoload.php";

$post = Post::getPostById($id);

if (!$post) {
    header("Location:index.php");
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

<body style="background-color:#ffcfef">
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
    <h3 class="text-xl text-center my-2">Detalles</h3>

    <!-- TABLA POSTS -->

    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow mx-auto mt-10">
        <img class="rounded-t-lg" src="<?php echo "./../" . $post->imagen ?>" alt="<?php echo $post->titulo ?>" />
        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?php echo $post->titulo ?></h5>
            <p class="mb-3 font-normal text-gray-700"><?php echo $post->descripcion ?></p>
            <p class="mb-3 font-normal text-gray-700"><span class="font-bold">User: </span> <?php echo $post->email ?></p>
        </div>
    </div>

</body>

</html>