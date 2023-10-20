<?php

use App\ApiProvider\Provider;

require_once __DIR__ . "/../vendor/autoload.php";

$list = Provider::getFilms();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Api films</title>
</head>

<body style="background:black">
    <div class="container p-12 mx-auto">
        <?php
        foreach ($list as $film) {
            echo <<<TXT
            <div class="w-1/2 mx-auto mb-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded-t-lg h-96 mx-auto" src="{$film->poster_path}" alt="" />
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{$film->title}</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{$film->overview}</p>
                    <div class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Votos: {$film->vote_count}
                    </div>
                </div>
            </div>
            TXT;
        }
        ?>
    </div>
</body>

</html>