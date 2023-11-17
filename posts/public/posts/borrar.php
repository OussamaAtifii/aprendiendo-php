<?php

use App\Db\Post;

session_start();

if (!isset($_POST['id']) || !isset($_SESSION['Email'])) {
    header("Location:index.php");
    die();
}

$idPost = $_POST['id'];
$idUser = $_SESSION['id'];

require_once __DIR__ . "/../../vendor/autoload.php";

$post = Post::getPostById($idPost, $idUser);  // Retorna false si no encuentra y en caso contrario devuelve la fila encontrada


if (!$post) {
    header("HTTP/1.1 401 Unauthorized");
    require __DIR__ . "/../errors/401.html";
    die();
}

// El post que se quiere borrar si es del usuario que lo quiere borrar.
$imagen = $post->imagen;

if (basename($imagen) != "default.jpg") {
    // Borrar imagen

    unlink("./../$imagen");
}

Post::delete($idPost);

$_SESSION['mensaje'] = "Post borrado correctamente";
header("Location:index.php");
