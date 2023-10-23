<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\ApiProvider\Provider;

$imageList = Provider::getImages();

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
    <title>Api Images</title>
</head>

<body>
    <h1 class="text-4xl text-center p-10">IMAGENES DE MURCIA</h1>
    <div class="relative w-screen grid grid-cols-3 text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
        <?php
        foreach ($imageList as $image) {
            echo <<<TXT
            <div>
            <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white shadow-lg h-80 rounded-xl bg-clip-border">
            <img src="{$image->webformatURL}" alt="profile-picture" />
        </div>
        <div class="p-6 text-center">
            <h4 class="block mb-2 font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                {$image->user}
            </h4>
            <p class="block font-sans text-base antialiased font-medium leading-relaxed text-transparent bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text">
                Likes: {$image->likes}
            </p>
        </div>
            </div>
        TXT;
        }
        ?>
    </div>
</body>

</html>