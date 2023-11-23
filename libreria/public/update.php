<?php

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

use App\Db\Autores;
use App\Db\Libros;
use App\Utils\Utils;

use const App\Utils\MAYUS_ON;

require_once __DIR__ . "/../vendor/autoload.php";
$id = $_GET['id'];
$libro = Libros::read($id);

if (count($libro) == 0) {
    header("Location:index.php");
    die();
}

session_start();
$autores = Autores::getAutoresId();

if (isset($_POST['btn'])) {
    $titulo = Utils::sanearCadena($_POST['titulo'], MAYUS_ON);
    $sinopsis = Utils::sanearCadena($_POST['sinopsis'], MAYUS_ON);
    $autor_id = (int)$_POST['autor_id'];

    $errores = false;

    if (!Utils::isCadenaValida("Titulo", $titulo, 3)) {
        $errores = true;
    } else {
        if (Utils::existeTituloUpdate($titulo, $id)) {
            $errores = true;
        }
    }

    if (!Utils::isCadenaValida("Sinopsis", $sinopsis, 3)) {
        $errores = true;
    }

    if (!Utils::isAutorValid($autor_id)) {
        $errores = true;
    }

    $portada = $libro[0]->portada;
    if (is_uploaded_file($_FILES['portada']['tmp_name'])) {
        if (!Utils::isImgValida($_FILES['portada']['type'], $_FILES['portada']['size'])) {
            $errores = true;
        } else {
            $portada = "img/portadas/" . uniqid() . $_FILES['portada']['name'];
            if (!move_uploaded_file($_FILES['portada']['tmp_name'], "./" . $portada)) {
                $errores = true;
                $_SESSION['Imagen'] = "No se pudo subir la imagen";
            } else {
                if (basename($libro[0]->portada) !== "default-book.jpg") {
                    unlink("./{$libro[0]->portada}");
                }
            }
        }
    }

    if ($errores) {
        header("Location:update.php?id=$id");
        die();
    }

    (new Libros)->setTitulo($titulo)
        ->setPortada($portada)
        ->setSinopsis($sinopsis)
        ->setAutorId($autor_id)
        ->update($id);

    $_SESSION['mensaje'] = "Libro actualizado correctamente";
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
    <h3 class="my-2 text-xl text-center">ACTUALIZAR LIBRO</h3>
    <div class="w-1/3 mx-auto p-4 bg-gray-300 rounded-xl shadow-xl">
        <form action="update.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titulo">
                    TItulo
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" name="titulo" type="text" placeholder="Titulo del libro....." value="<?php echo $libro[0]->titulo ?>">
                <?php Utils::pintarErrores('Titulo') ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sinopsis">
                    Sinopsis
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sinopsis" name="sinopsis" type="text" placeholder="Sinopsis del libro....."><?php echo $libro[0]->sinopsis ?></textarea>
                <?php Utils::pintarErrores('Sinopsis') ?>

            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="autor">
                    Autor
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="autor_id" name="autor_id" type="text">
                    <?php
                    foreach ($autores as $autor) {
                        $autorLibro = ($autor->id == $libro[0]->autor_id) ? "selected" : "";
                        echo "<option value='{$autor->id}' $autorLibro> {$autor->apellidos}, {$autor->nombre} </option>";
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
                    <img src="<?php echo "./" . $libro[0]->portada ?>" alt="default-book" width="150px" class="rounded" id="img">
                </div>
            </div>
            <div class="mb-4 flex justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="btn"> <i class="fas fa-edit mr-2"></i>Save changes</button>
                <a href="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"><i class="fas fa-home mr-2"></i> Volver</a>
            </div>
        </form>
    </div>
</body>

</html>