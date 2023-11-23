      "ext-pdo": "*"
<?php

use App\Db\Libros;

if (!isset($_POST['idLibro'])) {
    header("Location:index.php");
    die();
}

require_once __DIR__ . "/../vendor/autoload.php";
session_start();

$id = $_POST['idLibro'];
$libro = Libros::read($id);

if (count($libro) == 0) {
    header("Location:index.php");
    die();
}

$portada = $libro[0]->portada;

if (basename($portada) != "default-book.jpg") {
    unlink("./img/portadas/" . $portada);
}

Libros::delete($id);

$_SESSION['mensaje'] = "Borrado correctamente";
header("Location:index.php");
