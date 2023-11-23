<?php

use App\Db\Autores;
use App\Db\Libros;
use App\Utils\Utils;

use const App\Utils\MAYUS_ON;

session_start();
require_once __DIR__ . "/../vendor/autoload.php";
$autores = Autores::getAutoresId();

if (isset($_POST['btn'])) {
    $titulo = Utils::sanearCadena($_POST['titulo'], MAYUS_ON);
    $sinopsis = Utils::sanearCadena($_POST['sinopsis'], MAYUS_ON);
    $autor_id = (int)$_POST['autor_id'];

    $errores = false;

    if (!Utils::isCadenaValida("Titulo", $titulo, 3)) {
        $errores = true;
    } else {
        if (Utils::existeTitulo($titulo)) {
            $errores = true;
        }
    }

    if (!Utils::isCadenaValida("Sinopsis", $sinopsis, 3)) {
        $errores = true;
    }

    if (!Utils::isAutorValid($autor_id)) {
        $errores = true;
    }

    $portada = "img/portadas/default-book.jpg";
    if (is_uploaded_file($_FILES['portada']['tmp_name'])) {
        if (!Utils::isImgValida($_FILES['portada']['type'], $_FILES['portada']['size'])) {
            $errores = true;
        } else {
            $portada = "img/portadas/" . uniqid() . $_FILES['portada']['name'];
            if (!move_uploaded_file($_FILES['portada']['tmp_name'], "./" . $portada)) {
                $errores = true;
                $_SESSION['Imagen'] = "No se pudo subir la imagen";
            }
        }
    }

    if ($errores) {
        header("Location:nuevo.php");
        die();
    }

    (new Libros)->setTitulo($titulo)
        ->setPortada($portada)
        ->setSinopsis($sinopsis)
        ->setAutorId($autor_id)
        ->create();

    $_SESSION['mensaje'] = "Libro guardado correctamente";
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

<body>
    <h3 class="my-2 text-xl text-center">CREAR LIBRO</h3>
    <div class="w-1/3 mx-auto p-4 bg-gray-300 rounded-xl shadow-xl">
        <form action="nuevo.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titulo">
                    TItulo
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" name="titulo" type="text" placeholder="Titulo del libro.....">
                <?php Utils::pintarErrores('Titulo') ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sinopsis">
                    Sinopsis
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sinopsis" name="sinopsis" type="text" placeholder="Sinopsis del libro....."></textarea>
                <?php Utils::pintarErrores('Sinopsis') ?>

            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="autor">
                    Autor
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="autor_id" name="autor_id" type="text">
                    <?php
                    foreach ($autores as $autor) {
                        echo "<option value='{$autor->id}'>{$autor->apellidos}, {$autor->nombre}</option>";
                    }
                    ?>
                </select>
                <?php Utils::pintarErrores('Autor_id') ?>
            </div>
            <div class="mb-4 flex justify-between gap-10">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="autor">
                        Portada
                    </label>
                    <input type="file" name="portada" oninput="img.src=window.URL.createObjectURL(this.files[0])" id="portada" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php Utils::pintarErrores('Imagen') ?>

                </div>
                <div>
                    <img src="./img/portadas/default-book.jpg" alt="default-book" width="150px" class="rounded" id="img">
                </div>
            </div>
            <div class="mb-4 flex justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="btn"> <i class="fas fa-save mr-2"></i>Create</button>
                <button type="reset" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" name="btn"> <i class="fas fa-paintbrush mr-2"></i>Reset</button>
                <a href="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"><i class="fas fa-home mr-2"></i> Volver</a>
            </div>
        </form>
    </div>
</body>

</html>