<?php

use Src\Models\Usuario;

session_start();
require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($_POST["id"])) {
    header("Location:index.php");
    die();
}

Usuario::delete(htmlspecialchars(trim($_POST["id"])));

$_SESSION["mensaje"] = "Usuario borrado correctamente";

header("Location:index.php");
